<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Illuminate\Database\QueryException;
use App\Models\product_variants;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductCates;
use App\Models\Shop;
use App\Models\ProductDetails;
use App\Models\Images;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Monolog\Handler\NullHandler;

class ShopController extends Controller
{
    ///
    public function getShop()
    {
        $shop = Shop::where('status', 1)->first();
        return response()->json([
            'success' => true,
            'shop' =>  $shop,
        ]);
    }
    ///
    public function shopUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link_url' => 'string|max:500',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        try {
            DB::beginTransaction();
            $shop = new Shop();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $shop->image = $imageName;
            }
            $shop->status = $request->status;
            $shop->link_url =  $request->link_url ?? null;
            $shop->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Upload shop successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    ///
    public function shopUpdate()
    {
        $shop = Shop::all();
        return response()->json([
            'success' => true,
            'dataShop' => $shop,
        ]);
    }
    ///
    public function removeShopImg($id)
    {
        try {
            DB::beginTransaction();
            $shop = Shop::find($id);
            if (!$shop) {
                return response()->json([
                    'success' => false,
                    'error' => ['shop not found.']
                ]);
            }

            $shop->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['shop deleted successfully.']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to shop section.']
            ]);
        }
    }
    ///
    public function editShopView($id)
    {
        $Shop = Shop::find($id);
        return response()->json([
            'success' => true,
            'dataShop' =>  $Shop
        ]);
    }
    ///
    public function handleUpdateShop(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        try {
            DB::beginTransaction();
            $shop = Shop::find($request->id);
            if (!$shop) {
                return response()->json([
                    'success' => false,
                    'erroe' => ['shop not found.']
                ]);
            }
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $fileName);
                $shop->image = $fileName;
            }
            $shop->status = $request->status;
            $shop->link_url = $request->link_url;
            $shop->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['shop updated successfully!']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to updated shop.']
            ]);
        }
    }
    public function getBag(Request $request)
    {
        $page = $request->input('page');
        $perPage = 36;
        $query = Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            'products.class',
            DB::raw('CAST(SUM(product_variants.quantity) AS UNSIGNED) as total_quantity'),
            'discounts.quantity as discount_quantity',
            'discounts.discount',
            'discounts.status',
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image1'),
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1 OFFSET 1) as image2')
        )
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->where('products.class', '=', 'bag')
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.class',
                'products.is_new',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'
            );

        $query->orderBy('products.created_at', 'desc');
        $productViews = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
        $hasMore = $productViews->count() >= $perPage;
        return response()->json([
            'success' => true,
            'productViews' => $productViews,
            'hasMore' => $hasMore,
            'page' => $page,
        ]);
    }
    ///
    public function getHat(Request $request)
    {
        $page = $request->input('page');
        $perPage = 36;
        $query = Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            'products.class',
            DB::raw('CAST(SUM(product_variants.quantity) AS UNSIGNED) as total_quantity'),
            'discounts.quantity as discount_quantity',
            'discounts.discount',
            'discounts.status',
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image1'),
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1 OFFSET 1) as image2')
        )
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->where('products.class', '=', 'hat')
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.class',
                'products.is_new',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'
            );

        $query->orderBy('products.created_at', 'desc');
        $productViews = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
        $hasMore = $productViews->count() >= $perPage;
        return response()->json([
            'success' => true,
            'productViews' => $productViews,
            'hasMore' => $hasMore,
            'page' => $page,
        ]);
    }
    ///
    public function getShoe(Request $request)
    {
        $page = $request->input('page');
        $perPage = 36;
        $query = Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            'products.class',
            DB::raw('CAST(SUM(product_variants.quantity) AS UNSIGNED) as total_quantity'),
            'discounts.quantity as discount_quantity',
            'discounts.discount',
            'discounts.status',
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image1'),
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1 OFFSET 1) as image2')
        )
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->where('products.class', '=', 'shoe')
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.class',
                'products.is_new',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'
            );

        $query->orderBy('products.created_at', 'desc');
        $productViews = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
        $hasMore = $productViews->count() >= $perPage;
        return response()->json([
            'success' => true,
            'productViews' => $productViews,
            'hasMore' => $hasMore,
            'page' => $page,
        ]);
    }
    ///
    public function getAccessory(Request $request)
    {
        $page = $request->input('page');
        $perPage = 36;
        $query = Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            'products.class',
            DB::raw('CAST(SUM(product_variants.quantity) AS UNSIGNED) as total_quantity'),
            'discounts.quantity as discount_quantity',
            'discounts.discount',
            'discounts.status',
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image1'),
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1 OFFSET 1) as image2')
        )
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->where('products.class', '=', 'accessory')
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.class',
                'products.is_new',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'
            );
        $query->orderBy('products.created_at', 'desc');
        $productViews = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
        $hasMore = $productViews->count() >= $perPage;
        return response()->json([
            'success' => true,
            'productViews' => $productViews,
            'hasMore' => $hasMore,
            'page' => $page,
        ]);
    }
    ////
    public function getClothe(Request $request)
    {
        $page = $request->input('page');
        $perPage = 36;
        $query = Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            'products.class',
            DB::raw('CAST(SUM(product_variants.quantity) AS UNSIGNED) as total_quantity'),
            'discounts.quantity as discount_quantity',
            'discounts.discount',
            'discounts.status',
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image1'),
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1 OFFSET 1) as image2')
        )
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->where('products.class', '=', 'clothes')
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.class',
                'products.is_new',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'
            );

        $query->orderBy('products.created_at', 'desc');
        $productViews = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
        $hasMore = $productViews->count() >= $perPage;
        return response()->json([
            'success' => true,
            'productViews' => $productViews,
            'hasMore' => $hasMore,
            'page' => $page,
        ]);
    }
}
