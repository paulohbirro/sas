<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\GerenteRegiaoRepository;
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

class GerenteRegiaoController extends Controller
{

    protected $gerenteRegiaoRepository;

    /**
     * Constructor
     */
    public function __construct(GerenteRegiaoRepository $gerenteRegiaoRepository)
    {
        $this->gerenteRegiaoRepository = $gerenteRegiaoRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->gerenteRegiaoRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $gerentes = $this->gerenteRegiaoRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('admin.gerenteRegiao.index')->with(compact('gerentes'));
    }
}
