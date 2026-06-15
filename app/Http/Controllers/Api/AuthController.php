<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /** Inscription d'un nouveau patient via l'API */
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8',
            'telephone' => 'nullable|string|max:20',
        ]);

        $user  = User::create([
            'name'      => $data['name'],
            'prenom'    => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'telephone' => $data['telephone'] ?? null,
            'role'      => 'patient',
        ]);

        $token = $user->createToken('flutter-app')->plainTextToken;

        return response()->json(['success' => true, 'token' => $token, 'user' => $user], 201);
    }

    /** Connexion et génération d'un token Sanctum */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['success' => false, 'message' => 'Identifiants incorrects.'], 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('flutter-app')->plainTextToken;

        return response()->json(['success' => true, 'token' => $token, 'user' => $user]);
    }

    /** Déconnexion (révocation du token actuel) */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'Déconnecté avec succès.']);
    }

    /** Profil de l'utilisateur connecté */
    public function profile(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'user'    => $request->user()->load('doctor'),
        ]);
    }

    /** Mise à jour du profil */
    public function updateProfile(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'      => 'sometimes|string|max:255',
            'telephone' => 'sometimes|string|max:20',
        ]);

        $request->user()->update($data);

        return response()->json(['success' => true, 'user' => $request->user()]);
    }
}
