<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // GET /api/users
    public function get(): JsonResponse
    {
        $users = User::query()
            ->select([
                'id',
                'username',
                'name',
                'email',
                'created_at',
                'updated_at',
            ])
            ->orderBy('id')
            ->paginate(10);

        return response()->json($users);
    }

    // POST /api/users/create
    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                'unique:users,username',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'name' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente.',
            'user' => $user->only([
                'id',
                'username',
                'name',
                'email',
                'created_at',
            ]),
        ], 201);
    }

    // POST /api/users/login
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where(
            'email',
            $validated['email']
        )->first();

        if (
            !$user ||
            !Hash::check(
                $validated['password'],
                $user->password
            )
        ) {
            return response()->json([
                'message' => 'Email o contraseña incorrectos.',
            ], 401);
        }

        return response()->json([
            'message' => 'Inicio de sesión correcto.',
            'user' => $user->only([
                'id',
                'username',
                'name',
                'email',
                'created_at',
                'updated_at',
            ]),
        ]);
    }

    // PUT /api/users/update_username
    public function update_username(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'new_username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                'unique:users,username',
            ],
        ]);

        $user = $this->findUser(
            $validated['email'],
            $validated['password']
        );

        if (!$user) {
            return response()->json([
                'message' => 'Email o contraseña incorrectos.',
            ], 401);
        }

        $user->username = $validated['new_username'];
        $user->save();

        return response()->json([
            'message' => 'Username actualizado correctamente.',
            'user' => $user->only([
                'id',
                'username',
                'email',
            ]),
        ]);
    }

    // PUT /api/users/update_email
    public function update_email(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'new_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
        ]);

        $user = $this->findUser(
            $validated['email'],
            $validated['password']
        );

        if (!$user) {
            return response()->json([
                'message' => 'Email o contraseña incorrectos.',
            ], 401);
        }

        $user->email = $validated['new_email'];
        $user->save();

        return response()->json([
            'message' => 'Email actualizado correctamente.',
            'user' => $user->only([
                'id',
                'username',
                'email',
            ]),
        ]);
    }

    // PUT /api/users/update_password
    public function update_password(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user = $this->findUser(
            $validated['email'],
            $validated['password']
        );

        if (!$user) {
            return response()->json([
                'message' => 'Email o contraseña incorrectos.',
            ], 401);
        }

        $user->password = Hash::make(
            $validated['new_password']
        );

        $user->save();

        return response()->json([
            'message' => 'Contraseña actualizada correctamente.',
        ]);
    }

    // DELETE /api/users/delete
    public function delete(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = $this->findUser(
            $validated['email'],
            $validated['password']
        );

        if (!$user) {
            return response()->json([
                'message' => 'Email o contraseña incorrectos.',
            ], 401);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado correctamente.',
        ]);
    }

    private function findUser(
        string $email,
        string $password
    ): ?User {
        $user = User::where('email', $email)->first();

        if (
            !$user ||
            !Hash::check($password, $user->password)
        ) {
            return null;
        }

        return $user;
    }
}