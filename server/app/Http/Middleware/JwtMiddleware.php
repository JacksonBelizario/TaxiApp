<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();

        if (!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token não informado.',
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Token expirado.',
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao decodificar o token.',
            ], 401);
        }

        $request->credentials = $credentials;

        return $next($request);
    }
}
