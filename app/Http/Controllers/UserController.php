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
}
