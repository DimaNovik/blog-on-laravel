<?php
namespace App\Http\Controllers;

use App\cl_users;
use \Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AuthCalcController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'group_id' => 'required',
            'login' => 'required|unique:users',
            'password' => 'required',
        ]);


        $user = cl_users::add($request->all());
        $user->generatePassword($request->get('password'));

        return response()->json([
            'status' => 'ok'
        ]);
    }


    public function login()
    {
        $credentials = request(['login', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
