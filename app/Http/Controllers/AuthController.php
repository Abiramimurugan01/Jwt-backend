<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function signup(Request $request)
    {
     
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']); 
        $user = User::create($data);

        
        return response()->json(["message"=>"signup successful"], 201);
    }

    public function login(Request $request)
    {

        // if (Auth::attempt([
        //     'email' => $request->input('email'),
        //     'password' => $request->input('password')
        // ])) {
        //    
        //     $user = Auth::user();
        //     $response['token'] = JWTAuth::attempt($credentials); 
        //     $response['name'] = $user->name;
        //     return response()->json($response, 200);
        // } else {
        //     return response()->json(['message' => 'Invalid credentials'], 401);
        // }

        $credentials = $request->only('email','password');

        try {
            if ($token = JWTAuth::attempt($credentials)) {
                return response()->json(['token' => $token]);
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }


    public function detail()
    {
        $user=Auth::user();
        $response['user']=$user;
        return response()->json($response,200);
    }
    
    public function tokenerror()
    {
        return response()->json(['message' => 'Token is not valid'], 500);

    }

    
}


