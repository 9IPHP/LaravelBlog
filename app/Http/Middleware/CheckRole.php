<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class CheckRole
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if (!$this->auth->guest()) {
            if ($request->user()->hasRole($role) || $request->user()->isAdmin()) {
                return $next($request);
            }else{
                return redirect()->guest('/articles');
            }
        }
        return $request->ajax() ? response('Unauthorized.', 401) : redirect('/auth/login');
    }
}
