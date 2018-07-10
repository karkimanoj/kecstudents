<?php
namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Tenant;

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
        $tenant = Tenant::where('subdomain', $subdomain)->value('identifier');
      
        if($tenant)
        { 

           session(['tenant' =>  $tenant]);
           //setting laratrust table names according to tenant
           config(['laratrust.tables.roles' => $tenant.'_roles']);
           config([ 'laratrust.tables.permissions' => $tenant.'_permissions' ]);
           config(['laratrust.tables.teams' => $tenant.'_teams' ]);
           config(['laratrust.tables.role_user' => $tenant.'_role_user' ]);
           config(['laratrust.tables.permission_user' => $tenant.'_permission_user' ]);
           config(['laratrust.tables.permission_role' => $tenant.'_permission_'.$tenant.'_role' ]);
           
        }else
            abort(404);
      
        return $next($request);
    }
}
