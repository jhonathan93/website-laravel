<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;

class AuthController extends Controller {

    /**
     * @return Factory|View|Application
     */
    public function showLoginForm(): Factory|Application|View {
        return view('blade.pages.auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse {
        if (Auth::attempt($request->validated())) return redirect()->intended('/home')->with([
            'type' => 'success',
            'message' => "Bem-vindo, {$request->user()->name}!",
        ]);

        return back()->with([
            'type' => 'error',
            'message' => 'O email ou senha fornecidas estão invalidas!'
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse {
        $userName = auth()->user()->name;

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/')->with([
            'type' => 'success',
            'message' => "Até logo, $userName! Obrigado por usar nosso sistema.",
        ]);
    }
}
