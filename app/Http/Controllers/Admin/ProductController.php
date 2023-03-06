<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->seo()->setTitle('همه محصولات');

        $products = Product::query();

        if ($keyword = request('search')) {
            $products->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('id', 'LIKE', "%{$keyword}%");
        }

        $products = $products->latest()->paginate(20);
        return view('admin.products.all', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->seo()->setTitle('ایجاد محصول');
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required',
            'inventory' => 'required',
            'categories' => 'required',
            'attributes' => 'array',
        ]);

        $product = auth()->user()->products()->create($validData);
        $product->categories()->sync($validData['categories']);

        if (isset($validData['attributes']))
            $this->attachAttributesToProduct($product, $validData);

        alert()->success('با تشکر', 'محصول موردنظر با موفقیت ثبت شد');
        return redirect(route('admin.products.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return string
     */
    public function update(Request $request, Product $product)
    {
        $validData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
//            'image' => 'required',
            'inventory' => 'required',
            'categories' => 'required',
            'attributes' => 'array',
        ]);

        Storage::disk('public')->putFileAs('files', $request->file('file'), $request->file('file')->getClientOriginalName());

        $product->update($validData);
        $product->categories()->sync($validData['categories']);

        $product->attributes()->detach();

        if (isset($validData['attributes']))
            $this->attachAttributesToProduct($product, $validData);

        alert()->success('با تشکر', 'محصول موردنظر با موفقیت ویرایش شد');
        return redirect(route('admin.products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        alert()->success('با تشکر', 'محصول موردنظر با موفقیت حذف شد');

        return back();
    }

    /**
     * @param $attributes1
     * @param Product $product
     * @return void
     */
    protected function attachAttributesToProduct($attributes1, Product $product): void
    {
        $attributes = collect($attributes1);
        $attributes->each(function ($item) use ($product) {
            if (is_null($item['name']) || is_null($item['value'])) return;

            $attr = Attribute::firstOrCreate(
                ['name' => $item['name']]
            );

            $attr_value = $attr->values()->firstOrCreate(
                ['value' => $item['value']]
            );
            $product->attributes()->attach($attr->id, ['value_id' => $attr_value->id]);
        });
    }
}
