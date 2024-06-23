<?php

namespace App\Http\Controllers;

use App\Models\SizeChart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function HandleUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
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
            $sizechart = new SizeChart();
            $sizechart->cate_name =  $request->name;
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $sizechart->image_url = $imageName;
            $sizechart->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Upload size chart successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => [$e->getMessage()],
            ]);
        }
    }
    ///
    public function view()
    {
        $sizechart = SizeChart::all();
        return response()->json([
            'success' => true,
            'sizechart' => $sizechart,
        ]);
    }
    ///
    public function remove($id)
    {
        try {
            DB::beginTransaction();
            $sizechart = SizeChart::find($id);
            if (!$sizechart) {
                return response()->json([
                    'success' => false,
                    'error' => ['size chart not found.']
                ]);
            }

            $sizechart->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['size chart deleted successfully.']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
    ///
    public function edit($id)
    {
        $SizeChart = SizeChart::find($id);
        return response()->json([
            'success' => true,
            'data' =>  $SizeChart
        ]);
    }
    ///
    public function handleUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cate_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        try {
            DB::beginTransaction();
            $size = SizeChart::find($request->id);
            if (!$size) {
                return response()->json([
                    'success' => false,
                    'erroe' => ['size chart not found.']
                ]);
            }
            $size->cate_name = $request->cate_name;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $fileName);
                $size->image_url = $fileName;
            }
            $size->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['size chart updated successfully!']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['size chart to updated section.']
            ]);
        }
    }
}
