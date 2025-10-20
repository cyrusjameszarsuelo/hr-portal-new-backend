<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MicrosoftAuthController extends Controller
{
    public function redirectToMicrosoft()
    {
        // Use stateless because the frontend (React) is on a different origin
        // and we issue tokens instead of using session-based auth.
        /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
        $driver = Socialite::driver('microsoft');

        return $driver->stateless()->redirect();
    }

    public function handleMicrosoftCallback()
    {
        try {
            // Debug: log incoming request for diagnosis (remove in production)
            $query = request()->query();
            Log::info('Microsoft callback hit', ['full_url' => request()->fullUrl(), 'query' => $query]);

            // If the authorization code is missing, return helpful debug info
            if (!array_key_exists('code', $query)) {
                return response()->json([
                    'error' => 'missing_code',
                    'message' => 'Authorization code not present in callback. Make sure the redirect URI matches what is registered in Azure and that the initial auth request completed successfully.',
                    'request_full_url' => request()->fullUrl(),
                    'query' => $query,
                ], 400);
            }

            /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
            $driver = Socialite::driver('microsoft');
            $microsoftUser = $driver->stateless()->user();

            $user = User::updateOrCreate([
                'email' => $microsoftUser->getEmail(),
            ], [
                'name' => $microsoftUser->getName(),
                'microsoft_id' => $microsoftUser->getId(),
                // The users table requires a password; generate a random hashed password
                // since authentication for MS users will be token-based via Sanctum.
                'password' => Hash::make(Str::random(40)),
                'job_title' => $microsoftUser->getRaw()['jobTitle'] ?? null,
            ]);

            // Create API token (Sanctum)
            $token = $user->createToken('authToken')->plainTextToken;

            // If request expects JSON (ajax from frontend) return token JSON
            if (request()->wantsJson()) {
                return response()->json(['token' => $token, 'user' => $user]);
            }

            // Otherwise redirect to frontend with token in querystring
            return redirect(env('MICROSOFT_REDIRECT_FRONTEND_URI') . "?token={$token}&user_id={$user->id}");
        } catch (\Exception $e) {
            // Log the exception for investigation
            Log::error('Microsoft OAuth error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Unable to authenticate with Microsoft', 'message' => $e->getMessage()], 500);
        }
    }
}
