<?php

namespace App\Http\Controllers;

use App\Models\Catelogue;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function shop(string $id = null)
    {

        if ($id) {
            $products = Product::where('catelogue_id', $id)->latest('id')->paginate(9);
        } else {
            $products = Product::query()->latest('id')->paginate(9);
        }
        $categories = Catelogue::query()->withCount('products')->get();
        $colors = ProductColor::query()->withCount('variants')->get();
        $sizes = ProductSize::query()->withCount('variants')->get();
        // dd($colors->toArray());
        return view('client.shop', compact('categories', 'products', 'colors', 'sizes'));
    }
    public function filter(Request $request)
    {
        // dd($request->all());
        // $products = Product::query()->latest('id')->paginate(9);
        $sizes = $request->size;
        $colors = $request->color;

        $query = Product::with('variants');

        if ($sizes && $colors) {
            $query->whereHas('variants', function ($q) use ($sizes, $colors) {
                $q->whereIn('product_size_id', $sizes)
                    ->whereIn('product_color_id', $colors);
            });
        } else if ($sizes) {
            $query->whereHas('variants', function ($q) use ($sizes) {
                $q->whereIn('product_size_id', $sizes);
            });
        } else if ($colors) {
            $query->whereHas('variants', function ($q) use ($colors) {
                $q->whereIn('product_color_id', $colors);
            });
        }

        $products = $query->paginate(9);
        // ->paginate(9);
        // dd($products->toArray());
        $categories = Catelogue::query()->withCount('products')->get();
        $colors = ProductColor::query()->withCount('variants')->get();
        $sizes = ProductSize::query()->withCount('variants')->get();
        return view('client.shop', compact('categories', 'products', 'colors', 'sizes'));
    }
}
