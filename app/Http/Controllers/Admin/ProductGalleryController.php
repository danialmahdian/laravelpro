<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Product $product)
    {
        $images = $product->gallery()->latest()->paginate(30);
        return view('admin.products.gallery.all', compact('product', 'images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Product $product)
    {
        return view('admin.products.gallery.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'images.*.image' => 'required',
            'images.*.alt' => 'required|min:3',
        ]);
        collect($validated['images'])->each(function($image) use ($product) {
            $product->gallery()->create($image);
        });

        // alert()->success()
        return redirect(route('admin.products.gallery.index', ['product' => $product->id]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Product $product, ProductGallery $gallery)
    {
        return view('admin.products.gallery.edit', compact('product', 'gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Product $product, ProductGallery $gallery)
    {
        $validated = $request->validate([
            'image' => 'required',
            'alt' => 'required|min:3',
        ]);

        $gallery->update($validated);

        // alert()->success();
        return redirect(route('admin.products.gallery.index', ['product' => $product->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Product $product, ProductGallery $gallery)
    {
        $gallery->delete();
        //alert()->success();

        return redirect(route('admin.products.gallery.index', ['product' => $product->id]));
    }
}
