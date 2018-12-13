<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\AvaliacaoRepository;
use App\Contracts\Repositories\ConsultorRepository;
use Illuminate\Http\Request;

class ConsultorController extends Controller
{
    protected $consultorRepository;
    protected $avaliacaoRepository;

    /**
     * Constructor
     *
     * @param ConsultorRepository $turmaRepository
     */
    public function __construct(ConsultorRepository $consultorRepository, AvaliacaoRepository $avaliacaoRepository)
    {
        $this->consultorRepository = $consultorRepository;
        $this->avaliacaoRepository = $avaliacaoRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index()
    {
        return redirect()->route('consultores.interno');
    }

    /**
     * Lista consultores internos
     *
     * @param Request $request
     */
    public function interno(Request $request)
    {
        //Ordenação
        $this->consultorRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Condições
        $this->consultorRepository->where(['tipo' => 'interno']);

        //Resultado
        $consultores = $this->consultorRepository
            ->whereLike($request->get('like'))
            ->comAvaliacao()
            ->paginate($request->get('limit', 15));

        return view('consultor.interno')->with(compact('consultores'));
    }

    /**
     * Lista consultores externos
     *
     * @param Request $request
     */
    public function externo(Request $request)
    {
        //Ordenação
        $this->consultorRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Condições
        $this->consultorRepository->where(['tipo' => 'externo']);

        //Resultado
        $consultores = $this->consultorRepository
            ->whereLike($request->get('like'))
            ->comAvaliacao()
            ->paginate($request->get('limit', 15));

        return view('consultor.externo')->with(compact('consultores'));
    }

    /**
     * Ver
     *
     * @param int $consultorId
     * @param String $aba
     */
    public function ver($consultorId, $aba = null)
    {
        if(is_null($aba))
            return redirect()->route('consultores.ver', ['consultorId' => $consultorId, 'aba' => 'visaoGeral']);

        $consultor = $this->consultorRepository->getById($consultorId);

        $consultorGeral = $this->avaliacaoRepository->mediaNotaConsultor();

        return view('consultor.abas.'.$aba)->with(compact('consultor', 'aba', 'consultorGeral'));
    }
}
