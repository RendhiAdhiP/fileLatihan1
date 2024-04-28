<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Society;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $society = Society::where('login_tokens',$request->token)->first();

        if(!$society || $request->token == NULL){
            throw new HttpResponseException(response()->json(['Unauthorized user'],401));
        }

        $request->merge(['society'=>$society]);
        return $next($request);
    }
}
