<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\RequestResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        } catch (\Throwable $th) {
            return RequestResponse::error('Internal Server Error', $th, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            $user = $this->findUserByEmail($request->email);

            if (!$user) {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();

                return RequestResponse::success($user, 'User created successfully');
            } else {
                return RequestResponse::error('E-mail Already Registered', [], Response::HTTP_CONFLICT);
            }
        } catch (ValidationException $e) {
            return RequestResponse::error('Validation Error', $e->errors());
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index()
    {
        try {
            $users = DB::select('SELECT id, name, email FROM users');

            if ($users === []) {
                return RequestResponse::error('No Content', [], Response::HTTP_NO_CONTENT);
            }

            return RequestResponse::success($users, '');
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

        return response()->json(['result' => ['message' => 'Successfully logged out']]);
    }

    protected function respondWithToken($token)
    {
        $tomorrow = time() + 3600;
        return response()->json(['result' => [
            'access_token' =>  'bearer ' . $token,
            'expires_in' => $tomorrow
        ]]);
    }
}
