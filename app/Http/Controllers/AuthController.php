<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['authen', 'register']]);
    }
    public function authen (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                //'string',
                //'between:2,100',
                //'alpha_dash', // must used dash instead space
                //'unique:users,email_addres', // must input unique usernama, it will check email in table users colum email_addres
            ],
            'password' => [
                'required',
                //'string',
                //'min:6',
                //'regex:/[a-z]/',      // must contain at least one lowercase letter
                //'regex:/[A-Z]/',      // must contain at least one uppercase letter
                //'regex:/[0-9]/',      // must contain at least one digit
                //'regex:/[@$!%*#?&]/',  // must contain at least on special caracter
            ],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = Auth::attempt($validator->validated())) {
            return response()->json('Unauthorized', 401);
        }
        return $this->createNewToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => ['required',
                           //'string',
                           //'min:6',
                           //'confirmed',
                           //'regex:/[a-z]/',      // must contain at least one lowercase letter
                           //'regex:/[A-Z]/',      // must contain at least one uppercase letter
                           //'regex:/[0-9]/',      // must contain at least one digit
            ],
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

     public function logout()
     {
         auth()->logout();
         return response()->json(['message' => 'User successfully signed out']);
     }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile() {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token)
    {

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
            'directUrl' => url('api/home')
        ]);
    }
}
