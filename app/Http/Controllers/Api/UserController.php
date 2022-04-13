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
        $user = User::find($id);
        try {
            return response()->json(
                [
                    'name' => $user->name,
                    'email' => $user->email,
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
                $user->password =  Hash::make($request->confirmPassword);
                $user->save();
                return response()->json('Password Changed successfully !!');
            }
            return response()->json('Incorrect Password');
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
