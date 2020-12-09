<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    protected function getUser(Request $request)
    {
       return Auth::user();
    }

    protected function delete(Request $request, User $user): Response
    {
        $user->delete();

        return new Response(true, 204);
    }

    protected function edit(Request $request)
    {
        if (!$request->filled('user'))
            throw new \Exception('Invalid request.');

        $user = $request->input('user');
        $dbUser = User::find($user['id'])->first();

        return $dbUser->update($request->input('user'));
    }
}
