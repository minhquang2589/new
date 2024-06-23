<?php

namespace App\Http\Controllers;

use App\Models\Discounts;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class DiscountController extends Controller
{
    //
    public function view()
    {
        $discounts = DB::table('discounts')->where('quantity', '>', 0)->get();
        return response()->json([
            'success' => true,
            'discount' => $discounts,
        ]);
    }
    ///
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $Discounts = Discounts::find($id);
            if (!$Discounts) {
                return response()->json([
                    'success' => false,
                    'error' => ['Discounts not found.'],
                ]);
            }
            $Discounts->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['Discounts deleted successfully.'],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Error'],
            ]);
        }
    }
    public function discountEdit($id)
    {
        $discount = Discounts::find($id);
        return response()->json([
            'success' => true,
            'discount' =>  $discount
        ]);
    }
    ///
    public function handleUpdate(Request $request)
    {
        try {
            DB::beginTransaction();
            $status = $request->input('status');
            $discount = Discounts::find($request->id);
            $startDatetime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->input('start_datetime'))));
            $endDatetime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->input('end_datetime'))));

            if ($discount) {
                $discount->start_datetime = $startDatetime;
                $discount->end_datetime = $endDatetime;
                $discount->discount = $request->discount;
                $discount->quantity =  $request->quantity;
                $discount->remaining =  $request->remaining;
                $discount->status =  $status;
                $discount->save();
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' =>  ['Discount update successfully.']
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => true,
                'error' =>  ['An error occurred while update the Discount.'],
                'errors' => $e->getMessage()
            ]);
        }
    }
}
