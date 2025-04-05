<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function create()
    {
        return view('users.createUser');
    }

    public function login()
    {
        return view('users.loginUser');
    }

    public function register(RegisterUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.login')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function validateCredentials(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')->with('success', 'Usuário conectado');
        }

        return redirect()->route('user.login')->withErrors(['email' => 'As credenciais não correspondem.']);
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Usuário desconectado');
    }
}
