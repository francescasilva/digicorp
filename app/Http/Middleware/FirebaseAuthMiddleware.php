<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\Auth\Token\Exception\InvalidToken;
use Firebase\Auth\Token\Verifier;

class FirebaseAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $idToken = $request->cookie('firebase_token');

        if (!$idToken) {
            return redirect('/login');
        }

        try {
            $verifier = new Verifier(env('FIREBASE_PROJECT_ID'));
            $verifiedIdToken = $verifier->verifyIdToken($idToken);

            // Puedes agregar el UID u otro dato del usuario en la request si quieres
            $request->merge(['firebase_uid' => $verifiedIdToken->getClaim('sub')]);

        } catch (InvalidToken $e) {
            return redirect('/login');
        }

        return $next($request);
    }
}
