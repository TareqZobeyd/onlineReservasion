<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            if ($request->user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($request->user()->restaurant) {
                return redirect()->route('restaurant.dashboard');
            }
            return redirect()->route('home');
        }

        return view('auth.verify-email');
    }
}
