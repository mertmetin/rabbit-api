<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\PasswordReset;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    protected function resetPassword(Request $request, User $user): Response
    {
        $token = $request->input('token');
        $password = $request->input('password');

        if (!$token || !$password)
            throw new \InvalidArgumentException('Invalid request.');

        $passwordReset = PasswordReset::where('user_id', $user->id)
            ->orderBy('id')
            ->get()->last();

        if (!$passwordReset)
            throw new Exception('Invalid request.');

        if ($passwordReset->token != $token)
            throw new \Exception('Wrong code entered.');   

          User::where('id', $user->id)
            ->update(['password' => Hash::make($password)]);

        return new Response(true);
    }
}
