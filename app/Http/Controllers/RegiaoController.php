<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\AvaliacaoRepository;
use App\Contracts\Repositories\RegiaoRepository;
use Illuminate\Http\Request;

class RegiaoController extends Controller
{
    protected $regiaoRepository;
    protected $avaliacaoRepository;

    /**
     * Constructor
     *
     * @param RegiaoRepository $regiaoRepository
     * @param AvaliacaoRepository $avaliacaoRepository
     */
    public function __construct(RegiaoRepository $regiaoRepository, AvaliacaoRepository $avaliacaoRepository)
    {
        $this->regiaoRepository = $regiaoRepository;
        $this->avaliacaoRepository = $avaliacaoRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->regiaoRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $regioes = $this->regiaoRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('regiao.index')->with(compact('regioes'));
    }

    /**
     * Ver
     *
     * @param int $regiaoId
     * @param String $aba
     */
    public function ver($regiaoId, $aba = null)
    {
        if(is_null($aba))
            return redirect()->route('regioes.ver', ['regiaoId' => $regiaoId, 'aba' => 'visaoGeral']);

        $regiao = $this->regiaoRepository->getById($regiaoId);

        $npsGeral = $this->avaliacaoRepository->mediaNPS();
        $consultorGeral = $this->avaliacaoRepository->mediaNotaConsultor();
        $metodologiaGeral = $this->avaliacaoRepository->mediaNotaMetodologia();
        $atendimentoGeral = $this->avaliacaoRepository->mediaNotaAtendimento();

        $mediaGeralUltimos12Meses = $this->avaliacaoRepository->mediaGeralUltimosMeses(12);

        return view('regiao.abas.'.$aba)->with(compact('regiao', 'aba', 'npsGeral', 'consultorGeral', 'metodologiaGeral', 'atendimentoGeral', 'mediaGeralUltimos12Meses'));
    }





    

}
