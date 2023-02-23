<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

    public function login(Request $request){
        if(!Auth::attempt($request->only('username','password'))){
            return response()->json([
                'message' => 'Unauthorized'
            ],401);
        }

        $user = User::where('username', $request['username'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        $request->session()->put('xrfTOKEN', $token);

        return response()->json([
            'code' => 200,
            'status' => 'OK',
            'message' => 'Authorized',
            'data' => ['username' => $user->username, 'nama' => $user->nama],
            'token' => $token,
        ]);
    }

    public function logout(Request $request){
        $sessionToken = session()->get('xrfTOKEN');
        $getToken = PersonalAccessToken::findToken($sessionToken);

        if($getToken){
            $resetToken = $request->session()->put('xrfTOKEN', '');
            auth()->user()->tokens()->delete();
            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'message' => 'Successfully logout',
                'token' => $resetToken,
            ]);
        }

        return response()->json([
            'code' => 401,
            'status' => 'Error',
            'message' => 'Unauthorized',
        ]);
    }
}
