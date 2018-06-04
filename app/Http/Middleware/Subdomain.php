<?php
namespace App\Http\Middleware;

use Closure;


class Subdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
/*
    public function handle($request, Closure $next)
    {
        $route = $request->route();
        $subdomain = $route->parameter('subdomain');
    

        session(['tenant' =>  $subdomain]);
        $request->route()->forgetParameter('subdomain');
        //store parameter for later use
        return $next($request);
    }
*/
     public function handle($request, Closure $next)
    {   

        $subdomain = explode('.', $request->getHost())[0] ;
        //$subdomain = $route->parameter('subdomain');
       session(['tenant' =>  $subdomain]);
       //setting laratrust table names according to tenant
       config(['laratrust.tables.roles' => $subdomain.'_roles']);
       config(['laratrust.tables.permissions', $subdomain.'_permissions' ]);
       config(['laratrust.tables.teams' => $subdomain.'_teams' ]);
       config(['laratrust.tables.role_user' => $subdomain.'_role_user' ]);
       config(['laratrust.tables.permission_user' => $subdomain.'_permission_user' ]);
       config(['laratrust.tables.permission_role' => $subdomain.'_permission_'.$subdomain.'_role' ]);
       
      //  $route->forgetParameter('subdomain');
        //store parameter for later use
        return $next($request);
    }
}
