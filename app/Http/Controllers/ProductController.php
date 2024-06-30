<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\product_variants;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductCates;
use App\Models\Images;
use Illuminate\Database\QueryException;



class ProductController extends Controller
{
   //
   public function handleSearch(Request $request)
   {
      $page = $request->input('page', 1);
      $perPage = 30;
      $query = $request->input('query');

      $totalResults = Product::where('name', 'like', "%{$query}%")
         ->count();

      $products = Product::select(
         'products.id',
         'products.name',
         'products.description',
         'products.price',
         'products.is_new',
         'products.sales_count',
         DB::raw('SUM(product_variants.quantity) as total_quantity'),
         'discounts.quantity as discount_quantity',
         'discounts.discount',
         'discounts.remaining',
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
            'products.is_new',
            'products.sales_count',
            'discounts.quantity',
            'discounts.remaining',
            'discounts.discount',
            'discounts.id'
         )
         ->orderBy('products.sales_count', 'desc')
         ->where('products.name', 'like', "%{$query}%")
         ->skip(($page - 1) * $perPage)
         ->take($perPage + 1)
         ->get();

      $hasMore = $products->count() > $perPage;
      if ($hasMore) {
         $products->pop();
      }
      return response()->json([
         'success' => true,
         'products' => $products,
         'hasMore' => $hasMore,
         'resultQuantity' => $totalResults,
      ]);
   }
   ///

   public function handleSearchChill(Request $request)
   {
      $query = $request->input('query');

      $totalResults = Product::where('name', 'like', "%{$query}%")
         ->count();

      $data = Product::select(
         'products.id',
         'products.name',
         'products.price',
         'products.sales_count',
         DB::raw('SUM(product_variants.quantity) as total_quantity'),
         'discounts.quantity as discount_quantity',
         'discounts.discount',
         'discounts.remaining',
         'discounts.id as discount_id',
         DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image')
      )
         ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
         ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
         ->groupBy(
            'products.id',
            'products.name',
            'products.price',
            'discounts.quantity',
            'discounts.remaining',
            'discounts.discount',
            'discounts.id',
            'products.sales_count',
         )
         ->where('products.name', 'like', "%{$query}%")
         ->orderBy('products.sales_count', 'desc')
         ->limit(5)
         ->get();
      return response()->json([
         'success' => true,
         'data' => $data,
         'resultQuantity' => $totalResults,
      ]);
   }

   public function view($id)
   {

      $product = Product::select(
         'products.id',
         'products.name',
         'products.description',
         'products.price',
         'products.is_new',
         'products.sales_count',
         'products.class',
         DB::raw('SUM(product_variants.quantity) as total_quantity'),
         'discounts.quantity as discount_quantity',
         'discounts.discount',
         'discounts.remaining',
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
            'products.is_new',
            'products.sales_count',
            'discounts.quantity',
            'discounts.remaining',
            'discounts.discount',
            'discounts.id',
            'products.class',

         )
         ->find($id);
      if (!$product) {
         return response()->json([
            'success' => false,
            'message' => ['Product not found'],
         ]);
      }
      $productVariants = product_variants::where('product_id', $id)->get();
      $ProductDetailImg = Images::where('product_id', $id)->get();
      $sizeIds = $productVariants->pluck('size_id')->unique()->filter();
      $colorIds = $productVariants->pluck('color_id')->unique()->filter();
      $sizes = Size::whereIn('id', $sizeIds)->get();
      $colors = Color::whereIn('id', $colorIds)->get();
      $product_info = DB::table('products')
         ->join('product_cates', 'products.cate_id', '=', 'product_cates.id')
         ->select(
            'products.*',
            'product_cates.gender as category_name',
            'product_cates.gender as category_genter',
         )
         ->where('products.id', '=', $id)
         ->first();

      return response()->json([
         'success' => true,
         'product_info' => $product_info,
         'ProductDetailImg' => $ProductDetailImg,
         'product' => $product,
         'productVariant' => $productVariants,
         'sizes' => $sizes,
         'colors' => $colors,

      ]);
   }
   ////
   public function relatedProduct(Request $request)
   {
      $page = $request->input('page');
      $perPage = 30;
      $productsMore = Product::inRandomOrder()
         ->skip(($page - 1) * $perPage)
         ->take($perPage)
         ->select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            DB::raw('SUM(product_variants.quantity) as total_quantity'),
            'discounts.quantity as discount_quantity',
            'discounts.discount',
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
            'discounts.quantity',
            'discounts.discount'
         )
         ->get();

      $hasMore = $productsMore->count() > 0;

      return response()->json([
         'success' => true,
         'productsMore' => $productsMore,
         'hasMore' => $hasMore
      ]);
   }


   ///
   public function newproduct()
   {
      return view('auth.newproduct');
   }
   //
   public function getNewproduct(Request $request)
   {
      $page = $request->input('page');
      $perPage = 36;
      $newproducts = Product::select(
         'products.id',
         'products.name',
         'products.description',
         'products.price',
         'products.is_new',
         DB::raw('SUM(product_variants.quantity) as total_quantity'),
         'discounts.quantity as discount_quantity',
         'discounts.discount',
         'discounts.status',
         DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image1'),
         DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1 OFFSET 1) as image2')

      )
         ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
         ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
         ->where('is_new', 1)
         ->groupBy(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            'discounts.quantity',
            'discounts.discount',
            'discounts.status'
         )
         ->skip(($page - 1) * $perPage)
         ->take($perPage)
         ->get();
      return response()->json([
         'success' => true,
         'newproducts' => $newproducts,
         'page' => $page,
      ]);
   }
   /////////
   public function checkStock(Request $request)
   {
      $productId = $request->input('product_id');
      $sizeName = $request->input('size');
      $colorName = $request->input('color');

      $size = Size::where('size', $sizeName)->first();
      $color = Color::where('color', $colorName)->first();

      if (!$size || !$color) {
         return response()->json([
            'success' => false,
            'message' => ['Size or color not found'],
         ]);
      }

      $product = Product::find($productId);
      $productVariant = ProductVariant::where('product_id', $product->id)
         ->whereHas('size', function ($query) use ($size) {
            $query->where('size', $size->size);
         })
         ->whereHas('color', function ($query) use ($color) {
            $query->where('color', $color->color);
         })
         ->first();

      if (!$productVariant) {
         return response()->json([
            'success' => false,
            'message' => ['Out of stock'],
         ]);
      }
      if ($productVariant->quantity > 0) {
         return response()->json([
            'success' => true,
            'size' => $sizeName,
            'color' => $colorName,
            'productVariant' => $productVariant,
         ]);
      } else {
         return response()->json([
            'success' => false,
            'message' => ['Out of stock'],
         ]);
      }
   }
   //
   public function checkQuantityProduct(Request $request)
   {
      $productId = $request->input('product_id');
      $productVariants = product_variants::where('product_id', $productId)->get();

      $totalQuantity = $productVariants->sum('quantity');
      $data = [
         'totalQuantity' => $totalQuantity
      ];

      return response()->json($data);
   }

   ///
   public function removeproduct($id)
   {
      try {
         DB::beginTransaction();
         $product = Product::find($id);
         if (!$product) {
            return response()->json([
               'success' => false,
               'message' => ['Product not found.']
            ]);
         }
         $product->delete();
         DB::commit();
         return response()->json([
            'success' => true,
            'message' => ['Product deleted successfully.']
         ]);
      } catch (\Exception $e) {
         DB::rollBack();
         return response()->json([
            'success' => false,
            'message' => ['Failed to delete product.']
         ]);
      }
   }




   //

}
