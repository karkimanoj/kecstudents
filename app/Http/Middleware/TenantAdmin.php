<?php

namespace App\Http\Middleware;

use Closure;

class TenantAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $subdomain = explode('.', $request->getHost())[0] ;  
        if($subdomain != 'tenantadmin')
        {
          abort(404);

        }
        return $next($request);
    }
}
