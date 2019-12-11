<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index(User $user)
    {
        $all_users = $user->getAllUsers(auth()->user()->id);

        return $all_users;
    }

    public function destroy(User $user)
    {
        $user = auth()->user();
        $user->destroyUser($user->id);

        return response($user, 200);    
    }
}