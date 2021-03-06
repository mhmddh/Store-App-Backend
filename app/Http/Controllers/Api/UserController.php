<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public static function getUserDetails($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'User not found'
                    ]
                );
            }
            return response()->json(
                [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email
                    ],
                    
                    'success' => true,
                    'message' => 'User found successfully !!'
                ]
            );
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function updateUser($id, Request $request)
    {
        $user = User::find($id);
        $input = $request->all();
        try {
            $user->update($input);
            return response()->json('Updated successfully !!');
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public static function changePassword($id, Request $request)
    {

        try {
            $user = User::find($id);
            if (Hash::check($request->oldPassword, $user->password)) {
                if (Hash::check($request->confirmPassword, $user->password)) {
                    return response()->json(['success' => false, 'message' => 'Please choose a new password !!']);
                }
                $user->password =  Hash::make($request->password);
                $user->save();
                return response()->json(['success' => true, 'message' => 'Password Changed Successfully !!']);
            }
            return response()->json(['success' => false, 'message' => 'Incorrect Password !!']);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
    }
}
