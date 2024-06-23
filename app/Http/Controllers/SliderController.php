<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\slider;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class SliderController extends Controller
{
    /////
    public function getSlider()
    {
        $slider = slider::where('status', 1)->get();
        return response()->json([
            'success' => true,
            'slider' => $slider
        ]);
    }
    public function getSliderSale()
    {
        $discountProduct = Product::select(
            'products.id',
            'products.name',
            'products.description',
            'products.price',
            'products.is_new',
            'discounts.quantity as discount_quantity',
            'discounts.discount',
            'discounts.status',
            DB::raw('(SELECT image FROM images WHERE product_id = products.id ORDER BY id LIMIT 1) as image')
        )
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('discounts', 'product_variants.discount_id', '=', 'discounts.id')
            ->where('discounts.quantity', '>', 0)
            ->where('discounts.status', 'Active')
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
            ->orderByDesc('products.sales_count')
            ->inRandomOrder()
            ->take(11)
            ->get();
        return response()->json([
            'success' => true,
            'sliderSale' =>  $discountProduct,
        ]);
    }
    //



    public function HandleUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'link_url' => 'required|string',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $fileName);
            } else {
                return response()->json([
                    'success' => true,
                    'error' => ['Please choose an image to upload.']
                ]);
            }
            $slider = new slider();
            $slider->name = $request->input('name');
            $slider->link_url = $request->input('link_url');
            $slider->image = $fileName;
            $slider->status = $request->status;
            $slider->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['slider upload successfully!']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => [$e->getMessage()]
            ]);
        }
    }
    ////
    public function sliderEditView()
    {
        $slider = slider::all();
        if ($slider) {
            return response()->json([
                'success' => true,
                'dataSlider' => $slider
            ]);
        }
    }
    ////
    public function removeSlider($id)
    {
        try {
            DB::beginTransaction();
            $slider = slider::find($id);
            if (!$slider) {
                return response()->json([
                    'success' => false,
                    'error' => ['Slider not found.']
                ]);
            }
            $slider->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['Slider deleted successfully.']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to delete Slider.']
            ]);
        }
    }
    ///
    public function editSliderView($id)
    {
        $sliderUpdate = Slider::findOrFail($id);
        return response()->json([
            'success' => true,
            'dataSlider' => $sliderUpdate
        ]);
    }
    ///
    public function handleUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'link_url' => 'required|string',
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
            $editViewSlider = slider::find($request->sliderId);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $fileName);
                $editViewSlider->image = $fileName;
            }
            $editViewSlider->name = $request->name;
            $editViewSlider->status = $request->status;
            $editViewSlider->link_url = $request->link_url;
            $editViewSlider->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['Update Slider successfully!']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to updated Slider.']
            ]);
        }
    }
}
