<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\GerenteGestorRepository;
use App\Contracts\Repositories\GerenteRegiaoRepository;
use App\Contracts\Repositories\MicroRegiaoRepository;
use App\Contracts\Repositories\MunicipioRepository;
use App\Contracts\Repositories\RegiaoRepository;
use App\Contracts\Repositories\TecnicoRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Contracts\Repositories\UedRepository;
use App\Contracts\Repositories\UgpRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class UgpController extends Controller
{

    protected $ugpRepository;

    /**
     * Constructor
     */
    public function __construct(UgpRepository $ugpRepository)
    {
        $this->ugpRepository = $ugpRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->ugpRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $ugps = $this->ugpRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('admin.ugp.index')->with(compact('ugps'));
    }
}
