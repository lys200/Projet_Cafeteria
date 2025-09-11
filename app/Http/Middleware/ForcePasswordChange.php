<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->force_password_change) {
            // Exclure les routes de changement de mot de passe
            if (!$request->is('profile*') && !$request->is('logout')) {
                return redirect()->route('profile.edit')
                    ->with('warning', 'Vous devez changer votre mot de passe avant de continuer.');
            }
        }

        return $next($request);
    }
}
