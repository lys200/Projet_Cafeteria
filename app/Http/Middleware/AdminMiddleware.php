<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }

     public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Vérifie si l'utilisateur est admin
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}
