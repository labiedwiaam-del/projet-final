<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Vérifie que l'utilisateur connecté possède le rôle requis.
     * Usage: middleware('role:admin') ou middleware('role:medecin')
     */
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if (!$request->user() || $request->user()->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé. Accès refusé.',
                ], 403);
            }

            // Redirect to the correct dashboard instead of showing a 403 page
            if ($request->user()) {
                $redirect = match($request->user()->role) {
                    'admin'   => route('admin.dashboard'),
                    'medecin' => route('doctor.dashboard'),
                    default   => route('patient.dashboard'),
                };
                return redirect($redirect)->with('error', 'Accès refusé. Vous avez été redirigé vers votre espace.');
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}
