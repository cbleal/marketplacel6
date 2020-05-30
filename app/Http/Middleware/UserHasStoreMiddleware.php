<?php

namespace App\Http\Middleware;

use Closure;

class UserHasStoreMiddleware
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
         // validação para acesso apenas de users que não tenham store
         if (auth()->user()->store()->count()) {

            flash('Você já tem uma loja.')->warning();
            return redirect()->route('admin.stores.index');
        }

        return $next($request);
    }
}
