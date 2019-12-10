<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function destroy(User $user)
    {
        $user = auth()->user();
        $user->destroyUser($user->id);

        return response($user, 200);    
    }
}
