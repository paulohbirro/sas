<?php

namespace App\Http\ViewComposers\Filtros;

use App\Contracts\Repositories\GestorRepository;
use Illuminate\Contracts\View\View;

class GestorFiltroComposer
{

    protected $gestorRepository;

    public function __construct(GestorRepository $gestorRepository)
    {
        $this->gestorRepository = $gestorRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('gestores', $this->gestorRepository->order('nome', 'ASC')->all(['id', 'nome']));
    }

}