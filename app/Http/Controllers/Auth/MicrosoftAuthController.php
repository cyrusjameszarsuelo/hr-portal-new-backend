<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\OrgStructure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MicrosoftAuthController extends Controller
{
    public function redirectToMicrosoft()
    {
        // get platform hint from the incoming query (default to 'web')
        $platform = request()->query('platform', 'web');

        // encode small state payload (base64 to keep it URL safe)
        $statePayload = base64_encode(json_encode(['platform' => $platform]));

        /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
        $driver = Socialite::driver('microsoft');

        // include our state payload in the provider request (stateless flow)
        return $driver->stateless()->with(['state' => $statePayload])->redirect();
    }

    public function handleMicrosoftCallback()
    {
        try {
            // Log incoming request for diagnosis
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
                'job_title' => $microsoftUser->user['jobTitle'] ?? null,
                'password' => "password", // Hash::make(Str::random(16)), // Random password since we use Microsoft OAuth
                'last_login_at' => now(),
            ]);

            // Link user to org structure if a matching record exists by email
            $orgStructure = OrgStructure::where('email', $user->email)->first();
            if ($orgStructure && !$orgStructure->user_id) {
                $orgStructure->update(['user_id' => $user->id]);
            }

            // Create API token (Sanctum)
            $token = $user->createToken('authToken')->plainTextToken;

            // Decide which frontend redirect to use based on the state payload
            $state = request()->query('state');
            $platform = 'web';
            if ($state) {
                // attempt to decode state if we encoded it earlier
                $decoded = @json_decode(base64_decode($state), true);
                if (is_array($decoded) && !empty($decoded['platform'])) {
                    $platform = $decoded['platform'];
                }
            }

            // pick the target frontend redirect
            $frontendTarget = ($platform === 'mobile')
                ? env('MICROSOFT_REDIRECT_FRONTEND_URI_MOBILE')
                : env('MICROSOFT_REDIRECT_FRONTEND_URI');

            // If request expects JSON (ajax from frontend) return token JSON
            if (request()->wantsJson()) {
                return response()->json(['token' => $token, 'user' => $user]);
            }

            // Final redirect to the chosen frontend target
            return redirect($frontendTarget . "?token={$token}&user_id={$user->id}");
        } catch (\Exception $e) {
            Log::error('Microsoft OAuth error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Unable to authenticate with Microsoft', 'message' => $e->getMessage()], 500);
        }
    }
}
