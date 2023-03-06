<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Payment;
use Illuminate\Support\Str;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart = Cart::instance('cart-roocket');
        $cartItems = $cart->all();
        if ($cartItems->count()) {
            $price = $cartItems->sum(function ($cart) {
                return $cart['discount_percent'] == 0
                    ? $cart['product']->price * $cart['quantity']
                    : ($cart['product']->price - ($cart['product']->price * $cart['discount_percent'])) * $cart['quantity'];
            });

            $orderItems = $cartItems->mapWithKeys(function ($cart) {
                return [$cart['product']->id => ['quantity' => $cart['quantity']]];
            });

            $order = auth()->user()->orders()->create([
                'status' => 'unpaid',
                'price' => $price,
            ]);
            $order->products()->attach($orderItems);
            $token = env('PAYPING_TOKEN');
            // Create new invoice.
//            $invoice = (new Invoice)->amount($price);
            $invoice = (new Invoice)->amount(1000);

            return ShetabitPayment::callbackUrl(route('payment.callback'))->purchase($invoice, function ($driver, $transactionId) use ($order, $cart, $invoice) {

                $order->payments()->create([
                    'resnumber' => $invoice->getUuid(),
                ]);

                $cart->flush();

            })->pay()->render();

        }

        //alert()->error();
        return back();
    }

    public function callback(Request $request)
    {
        try {
            $payment = Payment::where('resnumber', $request->clientrefid)->firstOrFail();

            //  $payment->order->price
            $receipt = ShetabitPayment::amount(1000)->transactionId($request->clientrefid)->verify();

            $payment->update([
                'status' => 1
            ]);

            $payment->order()->update([
                'status' => 'paid'
            ]);

            alert()->success('پرداخت شما موفق بود');
            return redirect('/products');

        } catch (InvalidPaymentException $exception) {

            alert()->error($exception->getMessage());
            return redirect('/products');
        }
    }
}
