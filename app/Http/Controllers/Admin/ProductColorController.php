<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    const PATH_VIEW = 'admin.productcolors.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductColor::query()->latest('id')->get();
        // dd($data);
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
        ProductColor::query()->create($data);
        return redirect()->route('admin.productcolors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductColor $productcolor)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('productcolor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductColor $productcolor)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('productcolor'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductColor $productcolor)
    {
       $data = $request->all();
       $productcolor->update($data);
       return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductColor $productcolor)
    {
        $productcolor->delete();
        return back();
    }
}
