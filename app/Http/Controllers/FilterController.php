<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductCates;
use App\Models\ProductDetails;
use App\Models\Images;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    //
    public function filterCount($category)
    {
        if ($category == "null") {
            $category = NULL;
        }
        $newCount = Product::where('is_new', true)
            ->where(function ($query) use ($category) {
                if (!is_null($category)) {
                    $query->where('class', $category);
                }
            })
            ->count();

        $instockCount = ProductVariant::whereHas('product', function ($query) use ($category) {
            if (!is_null($category)) {
                $query->where('class', $category);
            }
        })
            ->where('quantity', '>', 0)
            ->groupBy('product_id')
            ->select('product_id', DB::raw('sum(quantity) as total'))
            ->get()
            ->pluck('total', 'product_id')
            ->count();



        $outstockCounts = ProductVariant::select('product_id')
            ->where('quantity', '>=', 0)
            ->whereHas('product', function ($query) use ($category) {
                if (!is_null($category)) {
                    $query->where('class', $category);
                }
            })
            ->groupBy('product_id')
            ->havingRaw('SUM(quantity) = 0')
            ->pluck('product_id')
            ->count();


        $discountCount = ProductVariant::whereIn('product_id', function ($query) use ($category) {
            $query->select('id')
                ->from('products')
                ->when($category, function ($query) use ($category) {
                    $query->where('class', $category);
                });
        })
            ->join('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->where('discounts.status', 'Active')
            ->groupBy('product_variants.product_id')
            ->select('product_variants.product_id', DB::raw('SUM(product_variants.quantity) as total_quantity'))
            ->pluck('total_quantity', 'product_variants.product_id')
            ->count();


        return response()->json([
            'success' => true,
            'newCount' => $newCount,
            'instockCount' => $instockCount,
            'outstockCount' => $outstockCounts,
            'discountCount' => $discountCount,
            'category' => $category,
        ]);
    }
}
