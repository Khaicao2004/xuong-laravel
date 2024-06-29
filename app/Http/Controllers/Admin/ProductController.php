<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catelogue;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\String_;

class ProductController extends Controller
{
    const PATH_VIEW = 'admin.products.';
    const PATH_UPLOAD = 'products';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::query()->with(['catelogue', 'tags'])->latest('id')->get();
        // dd($data->first()->toArray());             
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catelogues = Catelogue::query()->pluck('name', 'id')->all();
        $colors = ProductColor::query()->pluck('name', 'id')->all();
        $sizes = ProductSize::query()->pluck('name', 'id')->all();
        $tags = Tag::query()->pluck('name', 'id')->all();
        // dd($tags);
        return view(self::PATH_VIEW . __FUNCTION__, compact('catelogues', 'colors', 'sizes', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataProduct = $request->except(['product_variants', 'tags', 'product_galleries']);
        $dataProduct['is_active'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_hot_deal'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_good_deal'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_new'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_show_home'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['sku'];

        if ($dataProduct['img_thumbnail']) {
            $dataProduct['img_thumbnail'] = Storage::put('products', $dataProduct['img_thumbnail']);
        }

        $dataProductVariantsTmp = $request->product_variants;
        $dataProductVariants = [];
        // dd($dataProductVariantsTmp);
        foreach ($dataProductVariantsTmp as $key => $item) {
            $tmp = explode('-', $key);
            $dataProductVariants[] = [
                'product_size_id' => $tmp[0],
                'product_color_id' => $tmp[1],
                'quatity' => $item['quatity'] ?? 0,
                'image' => $item['image'] ?? null,
            ];
        }
        // dd($dataProductVariants);

        $dataProductTags = $request->tags;
        $dataProductGalleries = $request->product_galleries ?: [];
        try {
            DB::beginTransaction();

            /**@var Product $product */
            $product = Product::query()->create($dataProduct);

            foreach ($dataProductVariants as $dataProductVariant) {
                $dataProductVariant['product_id'] = $product->id;
                if ($dataProductVariant['image']) {
                    $dataProductVariant['image'] = Storage::put('products', $dataProductVariant['image']);
                }
                ProductVariant::query()->create($dataProductVariant);
                //  dd($dataProductVariants);

            }

            $product->tags()->sync($dataProductTags);
            foreach ($dataProductGalleries as $image) {
                ProductGallery::query()->create([
                    'product_id' => $product->id,
                    'image' => Storage::put('products', $image)
                ]);
            }
            DB::commit();

            return redirect()->route('admin.products.index');
        } catch (Exception $exception) {
            DB::rollBack();
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $sku)
    {
        $product = Product::query()->with(['catelogue'])->where('sku', 'LIKE', $sku)->first();
        $id = $product->id;
        $colors = ProductColor::query()->pluck('name', 'id')->all();
        $sizes = ProductSize::query()->pluck('name', 'id')->all();
        $variants = Product::with('variants')->find($id)->variants;
        $galleries = Product::with('galleries')->find($id)->galleries;
        $tags = Product::with('tags')->find($id)->tags;
        // dd($tags);
        return view(self::PATH_VIEW . __FUNCTION__, compact('colors', 'sizes', 'galleries', 'product', 'variants', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $sku)
    {
        $product = Product::query()->where('sku', 'LIKE', $sku)->first();
        $id = $product->id;
        $catelogues = Catelogue::query()->pluck('name', 'id')->all();
        $colors = ProductColor::query()->pluck('name', 'id')->all();
        $sizes = ProductSize::query()->pluck('name', 'id')->all();
        $tags = Tag::query()->pluck('name', 'id')->all();
        $variants = Product::with('variants')->find($id)->variants;
        $galleries = Product::with('galleries')->find($id)->galleries;
        $productTags = Product::with('tags')->find($id)->tags;
        // dd($tags);
        return view(self::PATH_VIEW . __FUNCTION__, compact('catelogues', 'colors', 'sizes', 'galleries', 'product', 'variants', 'tags', 'productTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $dataProduct = $request->except(['product_variants', 'tags', 'product_galleries']);
        $dataProduct['is_active'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_hot_deal'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_good_deal'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_new'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['is_show_home'] = isset($dataProduct['is_active']) ? 1 : 0;
        $dataProduct['slug'] = Str::slug($dataProduct['name']) . '-' . $dataProduct['sku'];
        $galleries = Product::with('galleries')->find($product->id)->galleries->toArray();
        // dd($request->product_galleries);
        // $productID = Product::query()->where('sku', 'LIKE', $request->sku)->first();
        // dd($productID);
        if ($request->has('product_galleries')) {
            foreach ($request->product_galleries as $key => $image) {
                
                if ($image != null) {
                    $imgPath = Storage::put('products', $image);
                    if($galleries != []){
                        ProductGallery::updateOrCreate(
                            ['id' => $galleries[$key]['id']],
                            ['image' => $imgPath],
                        );
                    }else{
                        $imgPath = Storage::put('products', $image);
                        ProductGallery::query()->create([
                            'product_id' => $product->id,
                            'image' => $imgPath,
                        ]);
                    }
                    
                }
            }
        }
        
        try {
            DB::beginTransaction();
            /**@var Product $product */
            if ($request->hasFile('img_thumbnail')) {
                $dataProduct['img_thumbnail'] = Storage::put('products', $dataProduct['img_thumbnail']);
            }
            $product->update($dataProduct);
            // dd($product);
            if ($request->has('product_variants')) {
                foreach ($request->product_variants as $key => $variant) {
                    if (!is_null($variant['quatity'])) {
                        $tmp = explode('-', $key);
                        $variant['product_size_id'] = $tmp[0];
                        $variant['product_color_id'] =  $tmp[1];

                        if (isset($variant['image'])) {
                            $variant['image'] = Storage::put('products', $variant['image']);
                        }
                    }
                    ProductVariant::updateOrCreate([
                        'product_id' => $product->id,
                        'product_size_id' => $variant['product_size_id'],
                        'product_color_id' => $variant['product_color_id'],
                    ], $variant);
                }
            }

            if ($request->has('tags')) {
                $product->tags()->sync($request->tags);
            } else {
                $product->tags()->sync($product->tags);
            }

            DB::commit();

            return redirect()->route('admin.products.index');
        } catch (Exception $exception) {
            DB::rollBack();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {
                $product->tags()->sync([]);
                $product->galleries()->delete();
                $product->variants()->delete();
                $product->delete();
            }, 3);
            return back();
        } catch (Exception $exception) {
        }
    }
}
