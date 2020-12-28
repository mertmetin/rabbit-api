<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\User;
use InvalidArgumentException;


class ChangePasswordController extends Controller
{
    protected function changePassword(Request $request, User $user): Response
    {
        if ($request->user()->cannot('update', $user))
            abort(403);

        $data = $request->validate([
            'password' => 'required|min:4',
            'oldPassword' => 'required|min:4',
        ]);

        if (!Hash::check($data['oldPassword'], $user->password))
            throw new \Exception('Wrong password.');

        $password = $data['password'];
        $user->password = Hash::make($password);
        $result = $user->save();

        return new Response($result, 200);
    }
}
