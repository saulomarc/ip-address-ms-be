<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = User::where('email', auth('api')->user()->email)->with('roles')->with('permissions')->first();
        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            auth('api')->logout();

            //access the x-session-id header
            $session_id = $request->header('X-Session-ID');

            //find the user_session which logged_out will be updated
            $user_session = UserSession::where('session_id', $session_id)->first();

            $user_session->logged_out = now();
            $user_session->save();

        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json([
            'access_token' => auth('api')->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $session_id = Str::uuid();

        //Create user session for this log in
        UserSession::create([
            'user_id' => auth('api')->user()->id,
            'session_id' => $session_id,
            'logged_on' => now()
        ]);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'session_id' => $session_id,
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function savePassword(Request $request) {
        $user = User::where('email', $request->email)->first();

        $hashedPassword = Hash::make($request->password);

        $user->password = $hashedPassword;
        $user->save();
    }
}
