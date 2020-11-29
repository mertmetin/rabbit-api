<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required', 
            'password' => 'required'
        ]);

        $credentials = $request->only('phone', 'password');

        if (!$token = Auth::attempt($credentials))
            return new Response(['error' => 'Unauthorized'], 401);

        if (!boolval(Auth::user()->active))
            return new Response(['error' => 'User not activated'], 401);

        return new Response(['token' => $token]);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        // Pass true to force the token to be blacklisted "forever"
        auth()->logout(true);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
