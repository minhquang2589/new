<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SliderBag;
use App\Models\Bag;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;


class SLiderBagController extends Controller
{
    //
    public function index()
    {
        $databag = SliderBag::where('status', 1)->first();

        $data = Product::select(
            'products.id',
            'products.name',
            'products.price',
            'products.is_new',
            'products.class',
            DB::raw('SUM(product_variants.quantity) as total_quantity'),
            'discounts.quantity as discount_quantity',
            'discounts.discount',
            'discounts.remaining',
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image')
        )
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->groupBy(
                'products.id',
                'products.name',
                'products.price',
                'products.is_new',
                'discounts.quantity',
                'discounts.remaining',
                'discounts.discount',
                'products.class'
            )
            ->where('products.class', 'bag')
            ->inRandomOrder()
            ->limit(2)
            ->get();
        return response()->json([
            'success' => true,
            'data' =>  $data,
            'dataBag' =>  $databag,
        ]);
    }
    ///
    public function handleUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:600',
            'link_url' => 'required|string|max:1000',
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
            $slider = new SliderBag();
            $slider->status = $request->status;
            $slider->link_url = $request->link_url;
            $slider->description = $request->description;
            $slider->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ['slider bag successfully.']
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
    public function view()
    {
        $data = SliderBag::all();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    ///
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $slider = SliderBag::find($id);
            if (!$slider) {
                return response()->json([
                    'success' => false,
                    'error' => ['slider bag not found.']
                ]);
            }

            $slider->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['slider bag deleted successfully.']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to delete slider bag.']
            ]);
        }
    }
    ///
    public function editSliderBagView($id)
    {
        $data = SliderBag::find($id);
        return response()->json([
            'success' => true,
            'data' =>  $data
        ]);
    }
    ///
    public function handleUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link_url' => 'required|string',
            'status' => 'required',
            'description' => 'required|string|max:300',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        $slider = SliderBag::find($request->id);
        if (!$slider) {
            return response()->json([
                'success' => false,
                'error' => ['slider bag not found.']
            ]);
        }
        try {
            DB::beginTransaction();
            $slider->status = $request->status;
            $slider->link_url = $request->link_url;
            $slider->description = $request->description;
            $slider->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['sider bag updated successfully!']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to updated sider bag.']
            ]);
        }
    }
}
