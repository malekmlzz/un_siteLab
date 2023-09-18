<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {       
            if($request->cookie('jwt_token')){
               $token = $request->cookie('jwt_token');
               
               $request->headers->set('Authorization' , 'Bearer' . $token);

               return $next($request); 
            }
            else{
               response()->json(['status' => 'Authorization Token not found'],401);
            }
            
            // $token = JWTAuth::parseToken();
            // $user = $token->authenticate();
            //  if($user){
               
            //     return $next($request); 
            //  }else{
            //     response()->json(['status' => 'Authorization Token not found'],401);
            //  }
    }
}
