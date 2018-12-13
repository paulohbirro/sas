<?php

namespace App\Http\ViewComposers\Filtros;

use App\Contracts\Repositories\RegiaoRepository;
use Illuminate\Contracts\View\View;

class RegiaoFiltroComposer
{

    protected $regiaoRepository;

    public function __construct(RegiaoRepository $regiaoRepository)
    {
        $this->regiaoRepository = $regiaoRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('regioes', $this->regiaoRepository->order('nome', 'ASC')->all(['id', 'nome']));
    }

}