<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\MicroRegiaoRepository;
use App\Contracts\Repositories\MunicipioRepository;
use App\Contracts\Repositories\RegiaoRepository;
use App\Contracts\Repositories\TecnicoRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class TecnicoController extends Controller
{

    protected $tecnicoRepository;

    /**
     * Constructor
     */
    public function __construct(TecnicoRepository $tecnicoRepository)
    {
        $this->tecnicoRepository = $tecnicoRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->tecnicoRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $tecnicos = $this->tecnicoRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('admin.tecnico.index')->with(compact('tecnicos'));
    }
}
