<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            if ($request->user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($request->user()->restaurant) {
                return redirect()->route('restaurant.dashboard');
            }
            return redirect()->route('home');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($request->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($request->user()->restaurant) {
            return redirect()->route('restaurant.dashboard');
        }
        return redirect()->route('home');
    }
}
