<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class RegisterPageController extends Controller
{
  public function show(Request $request, AuthService $authService)
  {
    if ($authService->isAuthenticated()) {
      return redirect()->route('home');
    }

    return view('auth.register', [
      'errorMessage' => (string) $request->query('error', ''),
    ]);
  }
}
