<?php

namespace App\Http\ViewComposers\Filtros;

use App\Contracts\Repositories\MicroRegiaoRepository;

use App\Facades\Sebrae;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;

class MicroRegiaoFiltroComposer
{

    protected $microRegiaoRepository;

    public function __construct(MicroRegiaoRepository $microRegiaoRepository)
    {
        $this->microRegiaoRepository = $microRegiaoRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if(Sebrae::is('Gerente de Regional'))
            $this->microRegiaoRepository->where(['regiao_id' => Sebrae::getDetalhes()->regiao_id]);

        elseif(Request::has('regiao_id'))
            $this->microRegiaoRepository->where(['regiao_id' => Request::get('regiao_id')]);

        $view->with('microregioes', $this->microRegiaoRepository->order('nome', 'ASC')->all(['id', 'nome']));
    }

}