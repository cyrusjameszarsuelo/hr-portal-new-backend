<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(string $id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    public function logout(string $id)
    {
        $user = User::find($id);
        
        if ($user) {
            // Revoke all tokens for the user
            $user->tokens()->delete();
        }

        return response()->json(['message' => 'Logged out successfully']);

    }
}
