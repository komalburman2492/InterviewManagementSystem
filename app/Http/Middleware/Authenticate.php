<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (Auth::check()) {
                $userRoleName = Auth::user()->userRole->name;
                switch ($userRoleName) {
                    case 'Admin':
                        return route('admin.dashboard');
                        break;

                    case 'Interviewer':
                        return route('interviewer.dashboard');
                        break;

                    case 'Candidate':
                        return route('candidate.dashboard');
                        break;
                    default:
                        return redirect(RouteServiceProvider::HOME);
                        break;
                }
                return route('login');
            }
        }

    }
}
