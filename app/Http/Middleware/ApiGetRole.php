<?php

namespace App\Http\Middleware;

use Closure;

class ApiGetRole
{
    public function handle($request, Closure $next)
    {
        $roles = $this->getRequiredRoleForRoute($request->route());
        if(!$request->user()){
            return response([
                    [
                        'status' => false,
                        'code' => 'UNAUTHORIZED',
                        'message' => 'You are not authorized to access this resource.',
                    ]
                ], 401);
        }
        
        if($request->user()->hasRole($roles, $request->route()) || !$roles)
        {
            return $next($request);
        }
        $title = "UNAUTHORIZED";
        $error_code = 401;
        $message_title = "INSUFFICIENT ROLE.";
        $message = 'You are not authorized to access this resource.';
        return response([
            [
                'status' => false,
                'code' => 'INSUFFICIENT_ROLE',
                'message' => 'You are not authorized to access this resource.',
                'uri' => $request->route()->uri,
                // 'role' => $request->user()->getUserRole($request->route()),
                // 'access_list' => $request->user()->getAccessList($request->route())
            ]
        ], 401);
    }
    private function getRequiredRoleForRoute($route)
    {
        $actions = $route->getAction();
        return isset($actions['api_roles']) ? $actions['api_roles'] : null;
    }
}