<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\size;
use App\Models\color;
use App\Models\ProductCates;
use App\Models\Discounts;
use App\Models\Images;
use App\Models\product_variants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Symfony\Component\VarDumper\VarDumper;

class CRUDController extends Controller
{
    //
    public function edit($id)
    {
        $product = Product::find($id);
        $productVariants = ProductVariant::where('product_id', $id)->get();
        $productImages = Images::where('product_id', $id)->get();
        $sizes = [];
        $colors = [];
        $quantities = [];
        foreach ($productVariants as $variant) {
            $size = Size::find($variant->size_id);
            $color = Color::find($variant->color_id);
            $sizes[] = $size ? $size->size : '';
            $colors[] = $color ? $color->color : '';
            $quantities[] = $variant->quantity;
        }
        $stock = product_variants::with('size', 'color')
            ->where('product_id', $product->id)
            ->get();

        foreach ($stock as $productVariant) {
            $size = $productVariant->size;
            $color = $productVariant->color;
            $quantity = $productVariant->quantity;
        }

        $discountInfo = Discounts::select(
            'discounts.start_datetime',
            'discounts.end_datetime',
            'discounts.discount',
            'discounts.remaining',
            DB::raw('discounts.quantity as total_quantity')
        )
            ->join('product_variants', function ($join) use ($id) {
                $join->on('discounts.id', '=', 'product_variants.discount_id')
                    ->where('product_variants.product_id', '=', $id);
            })
            ->where('product_variants.quantity', '>=', 0)
            ->first();

        $productCate = ProductCates::where('id', $product->cate_id)->first();

        return response()->json([
            'success' => true,
            'discountInfo' => $discountInfo,
            'product' => $product,
            'productImages' => $productImages,
            'stock' => $stock,
            'sizes' => $sizes,
            'colors' => $colors,
            'quantities' => $quantities,
            'productCate' => $productCate,
        ]);
    }
    //////////////////////////// update ////////////////////////////////////////////
    public function update(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'price' => 'required',
            'gender' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }

        $product = Product::findOrFail($request->productId);
        if (!$product) {
            return response()->json([
                'success' => false,
                'error' => ['Product not found!'],
            ]);
        }
        try {
            DB::beginTransaction();
            $product->name = $request->input('product_name');
            $product->price = $request->input('price');
            $product->description = $request->input('description');
            $product->is_new = $request->is_new;
            $product->save();


           

            $productCate = ProductCates::where('id', $product->cate_id)->first();
            $productCate->gender = $request->input('gender');
            $productCate->description = "For " . $request->input('gender');
            $productCate->save();
            if ($request->hasFile('images')) {
                Images::where('product_id', $product->id)->delete();
                foreach ($request->file('images') as $image) {
                    $originName = $image->getClientOriginalName();
                    $fileName = pathinfo($originName, PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $fileName . '_' . time() . '.' . $extension;
                    $image->move(public_path('images'), $fileName);
                    $url = asset('images/' . $fileName);
                    Images::create([
                        'product_id' => $product->id,
                        'image' => $fileName
                    ]);
                }
            }

            $discount = Discounts::whereHas('productVariants', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->orderBy('created_at', 'desc')->first();

            if ($discount) {
                $discount->discount = $request->discountnumber;
                $discount->quantity = $request->discountquantity;
                $discount->remaining = $request->discountremaining;
                $discount->save();
            } else {
                $discount = new Discounts();
                $discount->discount = $request->discountnumber;
                $discount->quantity = $request->discountquantity;
                $discount->remaining = $request->discountremaining;
                $discount->save();
            }
            if ($request->has('colors')) {
                $colors = json_decode($request->colors, true);
                foreach ($colors as $colorData) {
                    $colorName = $colorData['name'];
                    $colorModel = Color::updateOrCreate(['color' => $colorName]);
                    $totalQuantity = 0;
                    foreach ($colorData['sizes'] as $sizeData) {
                        $sizeName = $sizeData['name'];
                        $quantity = $sizeData['quantity'];
                        if ($quantity !== null) {
                            $totalQuantity += $quantity;
                            $sizeModel = Size::updateOrCreate(['size' => $sizeName]);
                            $productVariant = ProductVariant::where([
                                'product_id' => $product->id,
                                'size_id' => $sizeModel->id,
                                'color_id' => $colorModel->id,
                            ])->first();
                            if ($productVariant) {
                                $productVariant->quantity = $quantity;
                                $productVariant->discount_id = $discount->id;
                                $productVariant->save();
                            } else {
                                $productVariant = ProductVariant::create([
                                    'product_id' => $product->id,
                                    'size_id' => $sizeModel->id,
                                    'color_id' => $colorModel->id,
                                    'discount_id' => $discount ? $discount->id : null,
                                    'quantity' => $quantity,
                                ]);
                            }
                        }
                    }
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['Product updated successfully!'],
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'error' =>  $e->getMessage(),
            ]);
        }
    }
}
