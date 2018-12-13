<?php

namespace App\Http\ViewComposers\Filtros;

use App\Contracts\Repositories\MicroRegiaoRepository;
use App\Contracts\Repositories\MunicipioRepository;
use App\Facades\Sebrae;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;

class MunicipioFiltroComposer
{

    protected $municipioRepository;

    public function __construct(MunicipioRepository $municipioRepository)
    {
        $this->municipioRepository = $municipioRepository;
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
            $this->municipioRepository->whereRegiaoId(Sebrae::getDetalhes()->regiao_id);

        elseif(Request::has('regiao_id'))
            $this->municipioRepository->whereRegiaoId(Request::get('regiao_id'));


        if(Sebrae::is('Técnico de Microregião'))
            $this->municipioRepository->where(['micro_regiao_id' => Sebrae::getDetalhes()->micro_regiao_id]);

        elseif(Request::has('micro_regiao_id'))
            $this->municipioRepository->where(['micro_regiao_id' => Request::get('micro_regiao_id')]);


        $view->with('municipios', $this->municipioRepository->order('nome', 'ASC')->all(['id', 'nome']));
    }

}