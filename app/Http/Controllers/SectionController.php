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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

use App\Models\featured_sections;


class SectionController extends Controller
{


   public function getSection()
   {
      $Sections = Section::where('status', 1)->first();
      return response()->json([
         'success' => true,
         'section' =>  $Sections,
      ]);
   }
   ////
   public function HandleUpload(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'title' => 'required|string|max:200',
         'description' => 'required|string|max:500',
         'link_url' => 'required|string|max:500',
         'status' => 'required',
         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);
      if ($validator->fails()) {
         return response()->json([
            'success' => false,
            'error' => $validator->errors()->all(),
         ]);
      }
      $status = $request->status;
      $section = new Section();
      $section->name = $request->title;
      if ($request->hasFile('image')) {
         $image = $request->file('image');
         $imageName = time() . '_' . $image->getClientOriginalName();
         $image->move(public_path('images'), $imageName);
         $section->image = $imageName;
      }
      $section->status = $status;
      $section->link_url =  $request->link_url;
      $section->description = $request->description;
      $section->save();
      return response()->json([
         'success' => true,
         'message' => 'Upload section successfully!',
      ]);
   }
   ///
   public function view()
   {
      $section = Section::all();
      return response()->json([
         'success' => true,
         'dataSection' => $section,
      ]);
   }
   ////
   public function removeSection($id)
   {
      try {
         DB::beginTransaction();
         $section = Section::find($id);
         if (!$section) {
            return response()->json([
               'success' => false,
               'error' => ['Section not found.']
            ]);
         }

         $section->delete();

         DB::commit();
         return response()->json([
            'success' => true,
            'message' => ['Section deleted successfully.']
         ]);
      } catch (\Exception $e) {
         DB::rollBack();
         return response()->json([
            'success' => false,
            'error' => ['Failed to delete section.']
         ]);
      }
   }
   ///
   public function editSectionView($id)
   {
      $section = Section::find($id);
      return response()->json([
         'success' => true,
         'dataSection' =>  $section
      ]);
   }
   ///
   public function editSection(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'link_url' => 'required|string',
         'status' => 'required',
         'name' => 'required|string|max:100',
         'description' => 'required|string|max:300',
      ]);

      if ($validator->fails()) {
         return response()->json([
            'success' => false,
            'error' => $validator->errors()->all(),
         ]);
      }
      try {
         DB::beginTransaction();
         $section = Section::find($request->sectionId);
         if (!$section) {
            return response()->json([
               'success' => false,
               'erroe' => ['Section not found.']
            ]);
         }
         if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $fileName);
            $section->image = $fileName;
         }
         $section->name = $request->name;
         $section->status = $request->status;
         $section->link_url = $request->link_url;
         $section->description = $request->description;
         $section->save();

         DB::commit();
         return response()->json([
            'success' => true,
            'message' => ['Section updated successfully!']
         ]);
      } catch (\Exception $e) {
         DB::rollBack();
         return response()->json([
            'success' => false,
            'error' => ['Failed to updated section.']
         ]);
      }
   }
}
