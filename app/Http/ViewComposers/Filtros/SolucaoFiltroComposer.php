<?php

namespace App\Http\ViewComposers\Filtros;

use App\Contracts\Repositories\SolucaoRepository;
use Illuminate\Contracts\View\View;

class SolucaoFiltroComposer
{

    protected $solucaoRepository;

    public function __construct(SolucaoRepository $solucaoRepository)
    {
        $this->solucaoRepository = $solucaoRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('solucoes', $this->solucaoRepository->order('nome', 'ASC')->all(['id', 'nome']));
    }

}