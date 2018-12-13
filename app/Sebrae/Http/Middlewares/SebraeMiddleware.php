<?php

namespace App\Sebrae\Http\Middlewares;

use Closure;

class SebraeMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $perfil = null)
    {
        if(is_null($request->session()->get('perfil')))
            return redirect()->action('SelecionarController@getIndex');

        if(!is_null($perfil) && $request->session()->get('perfil') != $perfil)
            echo "Acesso negado para o perfil $perfil";

        return $next($request);
    }
}
