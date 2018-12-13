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
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class GerenteGestorController extends Controller
{

    protected $gerenteGestorRepository;

    /**
     * Constructor
     */
    public function __construct(GerenteGestorRepository $gerenteGestorRepository)
    {
        $this->gerenteGestorRepository = $gerenteGestorRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->gerenteGestorRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $gerentes = $this->gerenteGestorRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('admin.gerenteGestor.index')->with(compact('gerentes'));
    }
}
