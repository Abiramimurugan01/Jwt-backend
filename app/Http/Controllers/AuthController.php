<?php

namespace App\Http\Controllers;

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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'validator errors'], 401);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']); 
        $user = User::create($data);

        $response['token'] = $user->createToken('MyApp')->plainTextToken;
        $response['name'] = $user->name;
        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
       
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email',
        //     'password' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['message' => $validator->errors()], 400);
        // }

       
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ])) {

            $user = Auth::user();
            $response['token'] = $user->createToken('MyApp')->plainTextToken;
            $response['name'] = $user->name;
            return response()->json($response, 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }


    public function detail()
    {
        $user=Auth::user();
        $response['user']=$user;
        return response()->json($response,200);
    }

    
}
