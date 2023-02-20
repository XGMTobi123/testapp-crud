<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class AuthenticateWithToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        $validToken = Token::where('api_token', $token)
            ->where('api_token_expiration', '>', Carbon::now())
            ->first();

        if ($validToken) {
            return $next($request);
        }

        return response('Unauthorized', 401);
    }
}
