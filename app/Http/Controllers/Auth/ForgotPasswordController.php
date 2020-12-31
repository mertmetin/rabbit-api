<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\PasswordReset;
use Aws\Sns\SnsClient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    protected function sendPasswordResetCode(Request $request): Response
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'size:14']
        ]);

        $phone = $data['phone'];

        try {
            $user = User::where('phone', $phone)->firstOrFail();
        } catch (Exception $e) {
            throw new Exception('User not found.');
        }


        $token = $this->sendCode($phone);
        $params = [
            'token' => $token,
            'user_id' => $user->id
        ];
        $passwordReset = PasswordReset::create($params);
        $params['phone'] = $phone;

        return new Response($params, 201);
    }
    
    protected function sendCode($phone)
    {
        $token = mt_rand (1000 , 9999);
        $msg = 'Your rabbit code is ' . $token;
        $snsClient = new SnsClient([
            // 'profile' => 'default',
            'region' => 'us-east-1',
            'version' => '2010-03-31'
        ]);

        try { 
            $result = $snsClient->publish([
                'Message' => $msg,
                'PhoneNumber' => '+1' . $phone,
            ]);
        } catch (Exception $e) {
            throw new Exception('Unable to send a password reset code.');
        }

        return $token;
    }
}
