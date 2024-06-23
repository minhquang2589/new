<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class StoreController extends Controller
{
    //
    public function handleUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|image|max:2048',
            'content' => 'required',
        ],);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        try {
            DB::beginTransaction();
            $about = new About();
            if ($request->hasFile('images')) {
                $image = $request->file('images');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $about->content = $request->content;
                $about->image = $imageName;
                $about->save();
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'update blog successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'erorr' => ['An error occurred while uodate the blog.'],
            ]);
        }
    }
    ///
    public function view()
    {
        $store = About::all();
        return response()->json([
            'success' => true,
            'data' => $store
        ]);
    }
    ///
    public function edit($id)
    {
        $store = About::find($id);
        if (!$store) {
            return response()->json([
                'success' => false,
                'error' => ['about not found.']
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $store
        ]);
    }
    //
    public function storeInfo()
    {
        $store = About::first();
        if (!$store) {
            return response()->json([
                'success' => false,
                'error' => ['about not found.']
            ]);
        }
        return response()->json([
            'success' => true,
            'store' => $store
        ]);
    }
    //
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $about = About::find($id);
            if (!$about) {
                return response()->json([
                    'success' => false,
                    'error' => ['about not found.']
                ]);
            }
            $about->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['about deleted successfully.']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to delete about.']
            ]);
        }
    }
    ///
    public function handleUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ],);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }

        try {
            DB::beginTransaction();
            $about = About::find($request->id);
            if (!$about) {
                return response()->json([
                    'success' => false,
                    'error' => ['about not found.']
                ]);
            }
            if ($request->hasFile('images')) {
                $image = $request->file('images');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $about->image = $imageName;
            }
            $about->content = $request->content;
            $about->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'update about successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'erorr' => ['An error occurred while update the about.'],
            ]);
        }
    }
}
