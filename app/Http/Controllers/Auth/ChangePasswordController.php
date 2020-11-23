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
    protected function changePassword(Request $request, $userId): Response
    {
        $oldPassword = $request->input('oldPassword');
        $password = $request->input('password');

        if (!$oldPassword || !$password)
            throw new InvalidArgumentException('Invalid request.');

        try {
            $user = User::findOrFail($userId);
        } catch (ModelNotFoundException $exception) {
            throw new \Exception('User not found.');
        }

        if (!Hash::check($oldPassword, $user->password))
            throw new \Exception('Wrong password.');

        $result = User::where('id', $userId)
            ->update(['password' => Hash::make($password)]);

        return new Response($result);
    }
}
