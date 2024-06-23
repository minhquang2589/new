<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Payment;
use App\Models\Customers;
use Illuminate\Support\Facades\Redirect;
use App\Models\color;
use App\Models\Section;
use App\Models\Product;
use App\Models\ordernumber;
use App\Models\size;
use App\Models\User;
use App\Models\product_colors;
use App\Models\product_sizes;
use Illuminate\Support\Str;
use App\Models\product_variants;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderItems;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    //
    public function HandleUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'description' => 'max:500',
            'vimeo_video_url' => 'required|string|max:1000',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        $status = $request->status;
        try {
            DB::beginTransaction();
            $video = new Video();
            $video->title =  $request->title;
            $video->vimeo_video_url =  $request->vimeo_video_url;
            $video->status = $status;
            $video->description = $request->description;
            $video->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Upload video successfully!',
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
    public function videoView()
    {
        $video = Video::where('status', 1)->get();
        return response()->json([
            'success' => true,
            'video' => $video
        ]);
    }
    ///
    public function handleUpdate()
    {
        $video = Video::all();
        return response()->json([
            'success' => true,
            'video' => $video
        ]);
    }
    ///
    ////
    public function removeVideo($id)
    {
        try {
            DB::beginTransaction();
            $video = Video::find($id);
            if (!$video) {
                return response()->json([
                    'success' => false,
                    'error' => ['video not found.']
                ]);
            }

            $video->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['video deleted successfully.']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to delete video.']
            ]);
        }
    }
    ///
    public function editVideoView($id)
    {
        $video = Video::find($id);
        return response()->json([
            'success' => true,
            'dataVideo' =>  $video
        ]);
    }
    ///
    ///
    public function handleEditVideo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'description' => 'max:500',
            'vimeo_video_url' => 'required|string|max:1000',
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
            $video = Video::find($request->videoId);
            if (!$video) {
                return response()->json([
                    'success' => false,
                    'erroe' => ['video not found.']
                ]);
            }
            $video->title = $request->title;
            $video->description = $request->description;
            $video->vimeo_video_url = $request->vimeo_video_url;
            $video->status = $request->status;
            $video->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['Video updated successfully!']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to Video section.' . $e->getMessage()]
            ]);
        }
    }
}
