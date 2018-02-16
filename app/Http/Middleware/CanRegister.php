<?php namespace App\Http\Middleware;

use Closure;

class CanRegister
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
        if (firstUser()) {

            return $next($request);
        }

        return abort(403, 'User can\'t be registered.');
}
}