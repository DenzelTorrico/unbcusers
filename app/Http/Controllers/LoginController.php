<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Método para mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Método para manejar el inicio de sesión

    public function login(Request $request)
{
    $validatedData = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Check for soft-deleted user
    $user = User::withTrashed()
                ->where('email', $validatedData['email'])
                ->first();

    if (!$user || $user->deleted_at) {
        return back()->withErrors([
            'email' => $user ? 'El usuario está inactivo' : 'Usuario no encontrado',
        ]);
    }

    // Attempt authentication
    if (Auth::attempt($validatedData)) {
        // Authentication successful
        return redirect()->intended('/users');
    }

    // Incorrect credentials
    return back()->withErrors([
        'email' => 'Credenciales incorrectas',
    ]);
}
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
