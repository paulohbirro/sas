<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\AvaliacaoRepository;
use App\Contracts\Repositories\MicroRegiaoRepository;
use Illuminate\Http\Request;

class MicroRegiaoController extends Controller
{
    protected $microRegiaoRepository;
    protected $avaliacaoRepository;

    /**
     * Constructor
     *
     * @param ConsultorRepository $turmaRepository
     */
    public function __construct(MicroRegiaoRepository $microRegiaoRepository, AvaliacaoRepository $avaliacaoRepository)
    {
        $this->microRegiaoRepository = $microRegiaoRepository;
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
        $this->microRegiaoRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $microregioes = $this->microRegiaoRepository
            ->whereLike($request->get('like'))
            ->hasAvaliacoes()
            ->paginate($request->get('limit', 15));

        return view('microregiao.index')->with(compact('microregioes'));
    }

    /**
     * Ver
     *
     * @param int $microregiaoId
     * @param String $aba
     */
    public function ver($microregiaoId, $aba = null)
    {
        if(is_null($aba))
            return redirect()->route('microregioes.ver', ['microregiaoId' => $microregiaoId, 'aba' => 'visaoGeral']);

        $microregiao = $this->microRegiaoRepository->getById($microregiaoId);

        $npsGeral = $this->avaliacaoRepository->mediaNPS();
        $consultorGeral = $this->avaliacaoRepository->mediaNotaConsultor();
        $metodologiaGeral = $this->avaliacaoRepository->mediaNotaMetodologia();
        $atendimentoGeral = $this->avaliacaoRepository->mediaNotaAtendimento();

        $mediaGeralUltimos12Meses = $this->avaliacaoRepository->mediaGeralUltimosMeses(12);

        return view('microregiao.abas.'.$aba)->with(compact('microregiao', 'aba', 'npsGeral', 'consultorGeral', 'metodologiaGeral', 'atendimentoGeral', 'mediaGeralUltimos12Meses'));
    }

    

}
