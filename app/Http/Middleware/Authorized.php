<?php

namespace App\Http\Middleware;

use Closure;
use App\Tools\Permission;
use Illuminate\Support\Facades\Auth;

class Authorized
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
        if (Permission::isRoot())
            return $next($request);

        $groupId = Auth::user()->group_id;
        $routeName = $request->route()->getName();
        if ($routeName === 'logout' || $routeName === 'home')
            return $next($request);

        $key = Permission::$_permissionKey.md5($groupId);

        $get = json_decode(Permission::getPermission($key));
        $permission = isset($get->permission) ? $get->permission : [];

        if (!in_array($routeName, $permission))
            abort(401);

        return $next($request);
    }
}
