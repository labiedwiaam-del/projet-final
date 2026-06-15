<?php

namespace App\Http\Controllers\Auth;

use App\Rules\AllowedEmailDomain;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * Redirige vers le tableau de bord patient après inscription.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'prenom'    => ['required', 'string', 'max:100'],
            'nom'       => ['required', 'string', 'max:100'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class, new AllowedEmailDomain()],
            'password'  => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'prenom'    => $request->prenom,
            'nom'       => $request->nom,
            'telephone' => $request->telephone,
            'role'      => 'patient',
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirige vers la vérification email avant d'accéder au tableau de bord
        return redirect('/verify-email');
    }
}
