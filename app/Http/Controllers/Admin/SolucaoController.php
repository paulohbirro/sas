<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\MicroRegiaoRepository;
use App\Contracts\Repositories\MunicipioRepository;
use App\Contracts\Repositories\RegiaoRepository;
use App\Contracts\Repositories\SolucaoRepository;
use App\Contracts\Repositories\TecnicoRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class SolucaoController extends Controller
{

    protected $solucaoRepository;

    /**
     * Constructor
     */
    public function __construct(SolucaoRepository $solucaoRepository)
    {
        $this->solucaoRepository = $solucaoRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->solucaoRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $solucoes = $this->solucaoRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('admin.solucao.index')->with(compact('solucoes'));
    }
}
