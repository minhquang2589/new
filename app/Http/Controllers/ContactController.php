<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;


class ContactController extends Controller
{
    public function handleUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link_url' => 'string|max:500',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        try {
            DB::beginTransaction();
            $Contact = new Contact();
            $Contact->content = $request->content;
            $Contact->link_url =  $request->link_url;
            $Contact->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Upload content successfully!',
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
    public function getContact()
    {
        $data = Contact::first();
        return response()->json([
            'success' => true,
            'data' =>  $data,
        ]);
    }
    //
    public function getContactView()
    {
        $data = Contact::all();
        return response()->json([
            'success' => true,
            'data' =>  $data,
        ]);
    }
    ///
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $Contact = Contact::find($id);
            if (!$Contact) {
                return response()->json([
                    'success' => false,
                    'error' => ['Contact not found.']
                ]);
            }

            $Contact->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['Contact deleted successfully.']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to delete Contact.']
            ]);
        }
    }
    ///
    public function edit($id)
    {
        $Contact = Contact::find($id);
        return response()->json([
            'success' => true,
            'data' =>  $Contact
        ]);
    }
    ///
    public function handleUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link_url' => 'string|max:500',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        try {
            DB::beginTransaction();
            $Contact = Contact::find($request->id);
            if (!$Contact) {
                return response()->json([
                    'success' => false,
                    'erroe' => ['Contact not found.']
                ]);
            }
            $Contact->content = $request->content;
            $Contact->link_url = $request->link_url;
            $Contact->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => ['Contact updated successfully!']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => ['Failed to updated Contact.']
            ]);
        }
    }
}
