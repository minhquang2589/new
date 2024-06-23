<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\LookBook;


class LookbookController extends Controller
{
    //
    public function handleUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:300',
            'description' => 'required|string|max:600',
            'content' => 'required',
            'status' => 'required',
        ],);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        try {
            DB::beginTransaction();
            $lookbook = new LookBook();
            $lookbook->title = $request->title;
            $lookbook->description = $request->description;
            $lookbook->content = $request->content;
            $lookbook->status = $request->status;
            $lookbook->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Upload lookbook successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
    ///
    public function getLookbook(Request $request)
    {
        $page = $request->input('page');
        $perPage = 36;

        $extractFirstImageFilename = function ($content) {
            preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
            if (!empty($matches[1])) {
                return basename($matches[1]);
            }
            return null;
        };
        $lookbookViews = LookBook::select(
            'lookbook.id',
            'lookbook.title',
            'lookbook.description',
            'lookbook.content'
        )
            ->where('lookbook.status', '=', '1')
            ->groupBy(
                'lookbook.id',
                'lookbook.title',
                'lookbook.description',
                'lookbook.content'
            )
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        foreach ($lookbookViews as $lookbook) {
            $lookbook->first_image = $extractFirstImageFilename($lookbook->content);
        }
        $hasMore = $lookbookViews->count() >= $perPage;
        return response()->json([
            'success' => true,
            'lookbookViews' => $lookbookViews,
            'hasMore' => $hasMore,
            'page' => $page,
        ]);
    }
    //
    public function getLookbookDetail($id)
    {
        $lookbook = LookBook::find($id);
        return response()->json([
            'success' => true,
            'lookbook' => $lookbook,
        ]);
    }
    //
    public function view()
    {
        $extractFirstImageFilename = function ($content) {
            preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
            if (!empty($matches[1])) {
                return basename($matches[1]);
            }
            return null;
        };
        $lookbookViews = LookBook::select(
            'lookbook.id',
            'lookbook.title',
            'lookbook.content',
            'lookbook.status',
        )
            ->groupBy(
                'lookbook.id',
                'lookbook.title',
                'lookbook.content',
                'lookbook.status',

            )
            ->get();

        foreach ($lookbookViews as $lookbook) {
            $lookbook->image = $extractFirstImageFilename($lookbook->content);
        }
        return response()->json([
            'success' => true,
            'dataView' => $lookbookViews,
        ]);
    }
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $LookBook = LookBook::find($id);
            if (!$LookBook) {
                return response()->json([
                    'success' => false,
                    'error' => ['LookBook not found.']
                ]);
            }
            $LookBook->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['LookBook deleted successfully.']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to delete LookBook.']
            ]);
        }
    }
    ///
    public function editView($id)
    {
        $LookBook = LookBook::find($id);
        if (!$LookBook) {
            return response()->json([
                'success' => false,
                'error' => ['LookBook not found.']
            ]);
        }
        return response()->json([
            'success' => true,
            'data' =>  $LookBook
        ]);
    }
    ///
    public function handleUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:300',
            'description' => 'required|string|max:600',
            'content' => 'required',
            'status' => 'required',
        ],);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        try {
            DB::beginTransaction();
            $lookbook =  LookBook::find($request->id);
            if (!$lookbook) {
                return response()->json([
                    'success' => false,
                    'error' => ['LookBook not found.']
                ]);
            }
            $lookbook->title = $request->title;
            $lookbook->description = $request->description;
            $lookbook->content = $request->content;
            $lookbook->status = $request->status;
            $lookbook->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Update lookbook successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
