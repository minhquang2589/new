<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserManagementController extends Controller
{
    //
    public function index()
    {
        // $users = User::all();
        $users = User::all();
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }
    // 
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->is_admin) {
                return response()->json([
                    'success' => false,
                    'error' => ['Admin users cannot be deleted!']
                ]);
            }
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => ['User deleted successfully!'],
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    ///
    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => ['user not found!']
            ]);
        }
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
    ///
    public function userUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|regex:/^\d{10}$/',
            'birthday' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'address' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->all(),
            ]);
        }
        $user = User::findOrFail($request->userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => ['user not found!']
            ]);
        }
        $userData = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
        ];
        if ($request->filled('password')) {
            if ($request->password !== $request->confirm_password) {
                return response()->json([
                    'success' => false,
                    'error' => ['The password confirmation does not match.'],
                ]);
            }
            $userData['password'] = Hash::make($request->password);
        }
        $user->update($userData);
        return response()->json([
            'success' => true,
            'message' => ['User update successfully!']
        ]);
    }
}
