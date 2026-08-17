<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->get()->map(function ($user) {
            $userArray = $user->toArray();
            $userArray['role'] = $user->roles->first()?->name ?? 'admin'; // default to admin or fallback
            return $userArray;
        });

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['nullable', Password::defaults()],
            'role' => 'nullable|string|in:admin,editor',
            'send_reset_link' => 'boolean',
        ]);

        $password = $validated['password'] ?? \Illuminate\Support\Str::random(16);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($password),
        ]);

        if (isset($validated['role'])) {
            $user->assignRole($validated['role']);
        } else {
            $user->assignRole('admin'); // default role
        }

        if ($request->boolean('send_reset_link')) {
            $token = \Illuminate\Support\Facades\Password::getRepository()->create($user);
            $user->sendPasswordResetNotification($token);
        }

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userArray = $user->toArray();
        $userArray['role'] = $user->roles->first()?->name ?? 'admin';
        return response()->json($userArray);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', Password::defaults()],
            'role' => 'nullable|string|in:admin,editor',
        ]);

        if (isset($validated['name'])) {
            $user->name = $validated['name'];
        }

        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if (isset($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Optional: prevent deleting oneself
        if (request()->user() && request()->user()->id === $user->id) {
            return response()->json(['message' => 'Cannot delete yourself.'], 403);
        }

        $user->delete();
        return response()->json(null, 204);
    }

    /**
     * Send a password reset link to the user.
     */
    public function sendResetLink(User $user)
    {
        $token = \Illuminate\Support\Facades\Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);
        return response()->json(['message' => 'Password reset link sent.']);
    }
}
