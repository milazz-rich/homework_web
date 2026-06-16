<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    public function showLogin(): View|RedirectResponse
    {
        if ($this->authService->isAuthenticated()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        try {
            $this->authService->login((string) $request->input('email'), (string) $request->input('password'));
        } catch (RuntimeException $exception) {
            return back()->withInput($request->only('email'))->withErrors(['auth' => $exception->getMessage()]);
        }

        return redirect()->route('home');
    }

    public function showRegister(): View|RedirectResponse
    {
        if ($this->authService->isAuthenticated()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        try {
            $this->authService->register(
                (string) $request->input('nome'),
                (string) $request->input('cognome'),
                (string) $request->input('email'),
                (string) $request->input('password'),
                (string) $request->input('codice_verifica')
            );
        } catch (RuntimeException $exception) {
            return back()->withInput($request->except('password'))->withErrors(['auth' => $exception->getMessage()]);
        }

        return redirect()->route('home');
    }

    public function sendVerificationCode(Request $request): JsonResponse
    {
        try {
            $this->authService->sendVerificationCode((string) $request->input('email'));
        } catch (RuntimeException $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 422);
        }

        return response()->json(['success' => true, 'message' => 'Codice di verifica inviato.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout();

        return redirect()->route('home');
    }
}
