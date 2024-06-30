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
use App\Models\Images;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;




class DashboardController extends Controller
{
    public function getProductView(Request $request)
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
    /////
    public function getProductBestseller(Request $request)
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
            'products.sales_count',
            DB::raw('CAST(SUM(product_variants.quantity) AS UNSIGNED) as total_quantity'),
            'discounts.quantity as discount_quantity',
            'discounts.discount',
            'discounts.status',
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
                'products.is_new',
                'products.class',
                'products.sales_count',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'

            );
        $query->orderBy('sales_count', 'desc');
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
    public function getProductMen(Request $request)
    {
        $page = $request->input('page');
        $perPage = 36;
        $query = DB::table('products')
            ->select(
                'products.id',
                'products.name',
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
                'products.price',
                'products.is_new',
                'products.class',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'

            )
            ->join('product_cates', 'products.cate_id', '=', 'product_cates.id')
            ->where('product_cates.gender', 'men');
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
    /////
    public function getProductNew(Request $request)
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
            ->where('is_new', 1)
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
    public function getProductWomen(Request $request)
    {
        $page = $request->input('page');
        $perPage = 36;
        $query = DB::table('products')
            ->select(
                'products.id',
                'products.name',
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
            ->groupBy(
                'products.id',
                'products.name',
                'products.price',
                'products.is_new',
                'products.class',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'

            )
            ->join('product_cates', 'products.cate_id', '=', 'product_cates.id')
            ->where('product_cates.gender', 'women')
            ->where('products.class', '=', 'clothes');
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
    public function getProductUnisex(Request $request)
    {

        $page = $request->input('page');
        $perPage = 36;
        $query = DB::table('products')
            ->select(
                'products.id',
                'products.name',
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
            ->groupBy(
                'products.id',
                'products.name',
                'products.price',
                'products.is_new',
                'products.class',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'

            )
            ->join('product_cates', 'products.cate_id', '=', 'product_cates.id')
            ->where('products.class', '=', 'clothes')
            ->where('product_cates.gender', 'unisex');
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
    public function getProductDiscount(Request $request)
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
            ->leftJoin('images', 'products.id', '=', 'images.product_id')
            ->where('discounts.quantity', '>', 0)
            ->where('discounts.remaining', '>', 0)
            ->where('discounts.status', 'Active')
            ->where('products.class', '=', 'clothes')
            ->groupBy(
                'products.id',
                'products.name',
                'products.description',
                'products.price',
                'products.is_new',
                'products.class',
                'discounts.quantity',
                'discounts.discount',
                'discounts.status'
            );
        $query->orderBy('sales_count');

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
