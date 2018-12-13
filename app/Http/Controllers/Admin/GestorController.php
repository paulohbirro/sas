<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\GestorRepository;
use App\Contracts\Repositories\RegiaoRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class GestorController extends Controller
{

    protected $gestorRepository;

    /**
     * Constructor
     *
     * @param $solucaoRepository
     */
    public function __construct(GestorRepository $gestorRepository)
    {
        $this->gestorRepository = $gestorRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->gestorRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $gestores = $this->gestorRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('admin.gestor.index')->with(compact('gestores'));
    }
}
