<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use DateTime;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function username() {
        return 'email';
    }

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'index']]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!$user) return response()->json(['result' => ['message' => 'User Not Found']], Response::HTTP_NOT_FOUND);

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('api')->attempt($credentials)) {
               return response()->json(['result' => ['error' => 'Unauthorized']], Response::HTTP_UNAUTHORIZED);
        }
        return $this->respondWithToken($token, $request);

    }

    public function register(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!$user){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json(['result' => ['message' => 'User created successful.', 'user' => $user]], Response::HTTP_OK);

        }else{
            return response()->json(['result' => ['message' => 'E-mail Already Registered']], Response::HTTP_CONFLICT);
        }
    }

    public function index()
    {
        $users = User::all();
        if($users === []){
            return response()->json(['result' => ['message' => 'No Content']], Response::HTTP_NO_CONTENT);
        }
        return response()->json(['result' => ['users' => $users]], Response::HTTP_OK);
    }


    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['result' => ['message' => 'Successfully logged out']]);
    }


    protected function respondWithToken($token, Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $tomorrow = time() + 3600;
        return response()->json(['result' => [
            'access_token' =>  'bearer '.$token,
            'expires_in' => $tomorrow
        ]]);
    }

}
