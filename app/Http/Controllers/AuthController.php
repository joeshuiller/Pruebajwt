<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = User::where('email',$request->email)->first(); 
        return response()->json(compact('token', 'user'));
    }
    public function refresh()
    {
        $token = JWTAuth::getToken();
        $token = JWTAuth::refresh($token);
        return reponse()->json(compact('token'));
    }
    public function getusers($id)
    {
        $user = User::where('id',$id)->first(); 
        return reponse()->json($user, 200);
    }
    public function edit($id)
    {
        $user = User::where('id',$id)->first(); 
        return reponse()->json($user, 200);
    }
    public function logout()
    {
        $token = JWTAuth::getToken();
        $token = JWTAuth::invalidate($token);
        return reponse()->json(['logout']);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = $this->jwtAuth->parseToken()->authenticate()) {
                return response()->json(['error'=>'user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }
    public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:55',
                'surnames' => 'required|string|max:55',
                'telephone' => 'required|numeric|unique:users',
                'direction'=> 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'surnames' => $request->get('surnames'),
                'telephone' => $request->get('telephone'),
                'direction'=> $request->get('direction'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
        }
}
