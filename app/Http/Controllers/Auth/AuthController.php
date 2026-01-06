<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrgStructure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Manual login endpoint for non-SSO users.
     * Accepts JSON `{ email, password }` and returns a Sanctum token on success.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $user = User::where('email', $data['email'])->first();
            if (!$user) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            if (!Hash::check($data['password'], $user->password)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            // Optionally link org structure if present
            $orgStructure = OrgStructure::where('email', $user->email)->first();
            if ($orgStructure && !$orgStructure->user_id) {
                $orgStructure->update(['user_id' => $user->id]);
            }

            $user->update(['last_login_at' => now()]);

            $token = $user->createToken('authToken')->plainTextToken;

            if ($request->wantsJson()) {
                return response()->json(['token' => $token, 'user' => $user]);
            }

            // Fallback: return token JSON
            return response()->json(['token' => $token, 'user' => $user]);
        } catch (\Exception $e) {
            Log::error('Manual login error', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to authenticate', 'message' => $e->getMessage()], 500);
        }
    }
}
