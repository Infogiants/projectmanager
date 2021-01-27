<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware {

    public function handle($request, Closure $next, ...$role) {

        // dd($request->user()->roles()->pluck('slug')->toArray()[0]);

        // if (!$request->user()->hasRole($role)) {
        //     return redirect('/');
        //     //abort(404);
        // }

        if (!in_array($request->user()->roles()->pluck('slug')->toArray()[0], $role)) {
            return redirect('/');
            //abort(404);
        }

        // if ($permission !== null && !$request->user()->can($permission)) {
        //     abort(404);
        // }

        return $next($request);
    }

}
