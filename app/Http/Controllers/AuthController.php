<?php

namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ConstantTable;
use App\Utils\RequestResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function username()
    {
        return 'email';
    }

    private function findUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'index']]);
    }

    public function login(Request $request)
    {
        try {
            $user = $this->findUserByEmail($request->email);

            if (!$user) {
                return RequestResponse::error('User Not Found', [], Response::HTTP_NOT_FOUND);
            }

            $credentials = $request->only('email', 'password');

            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return RequestResponse::error('Unauthorized', [], Response::HTTP_UNAUTHORIZED);
            }

            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register(Request $request)
    {
        try {

            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => bcrypt($request->password),
                ]
            );

            return RequestResponse::success($user);
        } catch (ValidationException $e) {
            return RequestResponse::error('Validation Error', $e);
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index()
    {
        try {
            $users = User::select('id', 'name', 'email')->get();

            if ($users->isEmpty()) {
                return RequestResponse::error('No Content', [], Response::HTTP_NO_CONTENT);
            }

            return RequestResponse::success($users);
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return RequestResponse::success(['Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        $expiresIn = Auth::factory()->getTTL() * 60;
        return response()->json([
            'result' => [
                'access_token' =>  'bearer ' . $token,
                'expires_in' => $expiresIn,
            ],
        ]);
    }
}
