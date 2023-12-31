<?php

namespace App\Http\Controllers\Profile;

use App\Models\ActiveCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenAuthController extends Controller
{
    public function getPhoneVerify(Request $request)
    {
        if (!$request->session()->has('phone')) {
            return redirect(route('profile.2fa.manage'));
        }

        $request->session()->reflash();

        return view('profile.phone-verify');
    }

    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if (!$request->session()->has('phone')) {
            return redirect(route('profile.2fa.manage'));
        }


        $status = ActiveCode::verifyCode($request->token, $request->user());
        if ($status) {
            $request->user()->activeCode()->delete();
            $request->user()->update([
                'phone_number' => $request->session()->get('phone'),
                'two_factor_type' => 'sms',
            ]);

            alert()->success('عملیات موفقیت آمیز بود.', 'شماره تلفن و احراز هویت دو مرحله ای شما تایید شد.');
        } else {
            alert()->error('عملیات ناموفق بود.', 'شماره تلفن و احراز هویت دو مرحله ای شما تایید نشد.');
        }

        return redirect(route('profile.2fa.manage'));
    }
}
