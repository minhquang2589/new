<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\color;
use App\Models\Product;
use App\Models\ordernumber;
use App\Models\size;
use App\Models\Discounts;
use App\Models\User;
use App\Models\product_colors;
use App\Models\product_sizes;
use Illuminate\Support\Str;
use App\Models\product_variants;
use App\Models\ProductVariant;
use App\Models\Vouchers;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class RecentlyProductCrontroller extends Controller
{
    //
    public function addToRecently(Request $request)
    {
        try {
            $productId = $request->productId;
            $sessionId = Session::getId();
            $recentlyViewed = Redis::lrange($sessionId, 0, 120);
            if (!in_array($productId, $recentlyViewed)) {
                Redis::lpush($sessionId, $productId);
                Redis::ltrim($sessionId, 0, 120);
                Redis::expire($sessionId, 15 * 24 * 60 * 60);
            }
            return response()->json([
                'success' => true,
                'message' => 'add to recently!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function getRecentlyProducts()
    {
        try {
            $recentlyViewedKey = Session::getId();
            $type = Redis::type($recentlyViewedKey);
            if ($type != 'list' && $type != 'none') {
                Redis::del($recentlyViewedKey);
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid data type for recently viewed key. The key has been deleted.',
                ]);
            }


            $recentlyViewedIds = Redis::lrange($recentlyViewedKey, 0, 120);
            if (empty($recentlyViewedIds)) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                ]);
            }

            $recentlyProducts = Product::select(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                DB::raw('SUM(product_variants.quantity) as total_quantity'),
                'discounts.quantity as discount_quantity',
                'discounts.discount',
                'discounts.status',
                'discounts.id as discount_id',
                DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image')
            )
                ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
                ->groupBy(
                    'products.id',
                    'products.name',
                    'products.description',
                    'products.price',
                    'discounts.quantity',
                    'discounts.discount',
                    'discounts.status',
                    'discounts.id'
                )
                ->whereIn('products.id', $recentlyViewedIds)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $recentlyProducts->take(11)->values()->toArray(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    //
    public function getAllRecentlyProducts(Request $request)
    {

        try {
            if (Auth::check()) {
                $recentlyViewedKey =  Auth::id();
            } else {
                $recentlyViewedKey =  Session::getId();
            }
            $recentlyViewedIds = Redis::lrange($recentlyViewedKey, 0, 120);
            $products =  Product::whereIn('id', $recentlyViewedIds)->get();
            $page = $request->input('page');
            $perPage = 36;
            $recentlyProducts = Product::select(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                DB::raw('SUM(product_variants.quantity) as total_quantity'),
                'discounts.quantity as discount_quantity',
                'discounts.discount',
                'discounts.status',
                'discounts.id as discount_id',
                DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image1'),
                DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1 OFFSET 1) as image2')
            )
                ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
                ->groupBy(
                    'products.id',
                    'products.name',
                    'products.description',
                    'products.price',
                    'discounts.quantity',
                    'discounts.discount',
                    'discounts.status',
                    'discounts.id'
                )
                ->get();
            $recentlyViewedIds = $products->pluck('id')->toArray();
            $filteredProducts = $recentlyProducts->filter(function ($recentlyProducts) use ($recentlyViewedIds) {
                return in_array($recentlyProducts->id, $recentlyViewedIds);
            })->take($perPage)->values();
            $hasMore = $filteredProducts->count() >= $perPage;
            return response()->json([
                'success' => true,
                'data' => $filteredProducts->toArray(),
                'hasMore' => $hasMore,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => [$e->getMessage()],
            ]);
        }
    }
}
