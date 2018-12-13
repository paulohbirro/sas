<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\AvaliacaoRepository;
use App\Contracts\Repositories\SolucaoRepository;
use App\Facades\Sebrae;
use Illuminate\Http\Request;

class SolucaoController extends Controller
{

    protected $solucaoRepository;
    protected $avaliacaoRepository;

    /**
     * Constructor
     *
     * @param $solucaoRepository
     * @param $avaliacaoRepository
     */
    public function __construct(SolucaoRepository $solucaoRepository, AvaliacaoRepository $avaliacaoRepository)
    {
        $this->solucaoRepository = $solucaoRepository;
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
        $this->solucaoRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        /*
         * Gerente
         */
        if(Sebrae::is('Gerente de Regional'))
            $this->solucaoRepository->whereRegiaoId(Sebrae::getDetalhes()->regiao_id);
        else
            $this->solucaoRepository->whereRegiaoId($request->get('regiao_id'));

        //Resultado
        $solucoes = $this->solucaoRepository
            ->whereMicroRegiaoId($request->get('micro_regiao_id'))
            ->whereMunicipioId($request->get('municipio_id'))
            ->whereLike($request->get('like'))
            ->comAvaliacao()
            ->paginate($request->get('limit', 15));

        return view('solucao.index')->with(compact('solucoes'));
    }

    /**
     * Ver
     *
     * @param int $solucaoId
     * @param String $aba
     */
    public function ver($solucaoId, $aba = null)
    {
        if(is_null($aba))
            return redirect()->route('solucoes.ver', ['solucaoId' => $solucaoId, 'aba' => 'visaoGeral']);

        $solucao = $this->solucaoRepository->getById($solucaoId);

        $npsGeral = $this->avaliacaoRepository->mediaNPS();
        $consultorGeral = $this->avaliacaoRepository->mediaNotaConsultor();
        $metodologiaGeral = $this->avaliacaoRepository->mediaNotaMetodologia();
        $atendimentoGeral = $this->avaliacaoRepository->mediaNotaAtendimento();

        $mediaGeralUltimos12Meses = $this->avaliacaoRepository->mediaGeralUltimosMeses(12);

        if($aba == 'indicadores')
            $indicadores = $solucao->indicadoresPorMicroRegiao();

        return view('solucao.abas.'.$aba)->with(compact('solucao', 'indicadores', 'aba', 'npsGeral', 'consultorGeral', 'metodologiaGeral', 'atendimentoGeral', 'mediaGeralUltimos12Meses'));
    }

}
