<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    const PATH_VIEW = 'admin.productsizes.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductSize::query()->latest('id')->get();
        return view(self::PATH_VIEW . __FUNCTION__,compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name 
          ];
        ProductSize::query()->create($data);
        return redirect()->route('admin.productsizes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSize $productsize)
    {
        return view(self::PATH_VIEW . __FUNCTION__,compact('productsize'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSize $productsize)
    {
        return view(self::PATH_VIEW . __FUNCTION__,compact('productsize'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSize $productsize)
    {
       $data = $request->all();
       $productsize->update($data);
       return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSize $productsize)
    {
        $productsize->delete();
        return back();
    }
}
