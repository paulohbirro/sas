<?php

namespace App\Http\ViewComposers\Filtros;

use App\Contracts\Repositories\ConsultorRepository;
use Illuminate\Contracts\View\View;

class ConsultorFiltroComposer
{

    protected $consultorRepository;

    public function __construct(ConsultorRepository $consultorRepository)
    {
        $this->consultorRepository = $consultorRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('consultores', $this->consultorRepository->order('nome', 'ASC')->all(['id', 'nome']));
    }

}