<?php

namespace App\Http\Controllers;

use App\Facades\Sebrae;
use Illuminate\Http\Request;

class SelecionarController extends Controller
{

    /**
     * Index
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getIndex()
    {
        $perfis = Sebrae::getPerfis();

        if(count($perfis) == 1)
        {
            $perfil = key($perfis);
            $detalhe = reset($perfis);

            if($detalhe->count() == 1)
            {
                Sebrae::setPerfil($perfil, $detalhe->first()->id);

                return redirect('/');
            }
        }

        return view('selecionar.index')->with(compact('perfis'));
    }

    /**
     * Selecionar
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getSelecionar(Request $request)
    {
        if($request->has('perfil') && $request->has('perfilID'))
        {
            Sebrae::setPerfil($request->get('perfil'), $request->get('perfilID'));
            return redirect('/');
        }else
            return redirect()->back()->withErrors(['Informe um perfil']);
    }

    /**
     * Sair
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getSair()
    {
        Sebrae::forget();
        return redirect('/');
    }
}
