<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
        $user = User::find($id);
        $password = $request->password;
        $new_password = $request->new_password;
        try {
            if($password == $user->password){
                $user->password =  $new_password;
            }
            return response()->json('Password Changed successfully !!');
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
