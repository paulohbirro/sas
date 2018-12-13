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
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class UedController extends Controller
{

    protected $uedRepository;

    /**
     * Constructor
     */
    public function __construct(UedRepository $uedRepository)
    {
        $this->uedRepository = $uedRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->uedRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $ueds = $this->uedRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('admin.ued.index')->with(compact('ueds'));
    }
}
