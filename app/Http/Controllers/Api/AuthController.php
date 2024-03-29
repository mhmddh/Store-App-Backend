<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{

    /**
Login API
     * */
    public function login(Request $request)
    {
        try {
            //User check
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $id = Auth::user()->id;
                $user = User::find($id);
                //Setting login response
                $success['id'] = $user->id;
                $success['token'] = $user->createToken('auth-token')->plainTextToken;
                $success['name'] = $user->name;
                $success['email'] = $user->email    ;

                return response()->json([
                    'status' => 'success',
                    'data' => $success
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'data' => 'Unauthorized Access'
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
