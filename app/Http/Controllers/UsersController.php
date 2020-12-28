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

    protected function edit(Request $request, User $user): Response
    {
        if ($request->user()->cannot('create', User::class))
            abort(403);

        $data = $request->validate([
            'name' => 'string|max:255',
            'phone' => 'string|min:11',
            'email' => 'string|max:255'
        ]); 

        $result = $user->update($data);
        $user = User::find($user->id);

        return new Response($user, 200);
    }
}
