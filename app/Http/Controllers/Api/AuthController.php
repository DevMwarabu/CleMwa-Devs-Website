<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            AuditLogger::log('auth.login', 'User', $user?->id, [], ['email' => $request->email], 'failure');

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        AuditLogger::log('auth.login', 'User', $user->id, [], [], 'success');

        return response()->json([
            'token' => $user->createToken('mobile-admin')->plainTextToken,
            'user' => $this->userPayload($user),
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($this->userPayload($request->user()));
    }

    public function logout(Request $request)
    {
        AuditLogger::log('auth.logout', 'User', $request->user()->id);

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    private function userPayload(User $user): array
    {
        $user->load('roles');

        return array_merge($user->toArray(), [
            'role' => $user->roles->first()?->name ?? 'admin',
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }
}
