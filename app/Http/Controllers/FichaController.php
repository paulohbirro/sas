<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\TurmaRepository;
use App\Facades\Sebrae;
use App\PlanejamentoConsulta;
use App\SyncTurma;
use Exception;
use fpdi\FPDI;
use Illuminate\Http\Request;

class FichaController extends Controller
{
    protected $turmaRepository;

    /**
     * Constructor
     */
    public function __construct(TurmaRepository $turmaRepository)
    {
        $this->turmaRepository = $turmaRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        try {

            if ($request->has('codigo'))
            {
                $codigo = $request->get('codigo');

                if (!is_null($this->turmaRepository->getByCodigo($codigo)))
                    throw new Exception("Ficha da turma $codigo já foi impressa!");

                $sync = new SyncTurma($codigo);
                $turma = $sync->getTurmaXML();

                /*
                 * Tecnico
                 */
                if(Sebrae::is('Técnico de Microregião') && $turma->municipio->microregiao->nome != Sebrae::getDetalhes()->microRegiao->nome)
                    throw new Exception('Turma não '.$codigo.' é da microregião '.Sebrae::getDetalhes()->microRegiao->nome);
            }

            return view('ficha.index', compact('turma'));

        } catch (Exception $e) {
            return view('ficha.index', ['mensagem' => $e->getMessage()]);
        }

    }


    /**
     * Impressao de ficha
     *
     * @param Request $request
     */
    public function imprimir(Request $request)
    {
        $sync = new SyncTurma($request->get('codigo'));
        $turma = $sync->getTurmaModel();

        $pdf = new FPDI();
        $pdf->AddPage();
        $pdf->setSourceFile(storage_path('RG069.pdf'));
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0, 208);

        // now write some text above the imported page
        $pdf->SetFont('Arial', null, 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(101, 276);
        $pdf->Write(0, 'Turma: '.$turma->codigo);

        $pdf->Output();
    }

    /**
     * Lista fichas impressas
     *
     * @param Request $request
     */
    public function impressas(Request $request)
    {
        //Ordenação
        $this->turmaRepository->order($request->get('by', 'inicio'), $request->get('order', 'DESC'));

        /*
         * Tecnico
         */
        if(Sebrae::is('Técnico de Microregião'))
            $this->turmaRepository->whereMicroRegiaoId(Sebrae::getDetalhes()->micro_regiao_id);
        else
            $this->turmaRepository->whereMicroRegiaoId($request->get('micro_regiao_id'));

        /*
         * Gerente
         */
        if(Sebrae::is('Gerente de Regional'))
            $this->turmaRepository->whereRegiaoId(Sebrae::getDetalhes()->regiao_id);
        else
            $this->turmaRepository->whereRegiaoId($request->get('regiao_id'));

        //Resultado
        $turmas = $this->turmaRepository
            ->where([
                'status' => 'IMPRESSO',
                'municipio_id' => $request->get('municipio_id')
            ])
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('ficha.impressa')->with(compact('turmas'));
    }

    /**
     * Lista fichas enviadas e para serem enviadas
     *
     * @param Request $request
     */
    public function envio(Request $request)
    {
        //Ordenação
        $this->turmaRepository->order($request->get('by', 'inicio'), $request->get('order', 'DESC'));

        /*
         * Tecnico
         */
        if(Sebrae::is('Técnico de Microregião'))
            $this->turmaRepository->whereMicroRegiaoId(Sebrae::getDetalhes()->micro_regiao_id);
        else
            $this->turmaRepository->whereMicroRegiaoId($request->get('micro_regiao_id'));

        /*
         * Gerente
         */
        if(Sebrae::is('Gerente de Regional'))
            $this->turmaRepository->whereRegiaoId(Sebrae::getDetalhes()->regiao_id);
        else
            $this->turmaRepository->whereRegiaoId($request->get('regiao_id'));

        //Resultado
        $turmas = $this->turmaRepository
            ->whereStatus(['IMPRESSO', 'SUSPENSO', 'ENVIADO'])
            ->where(['municipio_id' => $request->get('municipio_id')])
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('ficha.envio')->with(compact('turmas'));
    }

    /**
     * Exibe formulário de envio
     *
     * @param Request $request
     */
    public function formulario($codigoTurma)
    {
        $turma = $this->turmaRepository->getByCodigo($codigoTurma);

        return view('ficha.formulario')->with(compact('turma'));
    }


    /**
     * Envia/Suspende fichas da turma
     *
     * @param Request $request
     */
    public function enviar(Request $request)
    {
        $turma = $this->turmaRepository->getById($request->get('turma_id'));

        $turma->update([
            'status' => $request->get('opcao'),
            'descricao' => $request->get('descricao')
        ]);

        return redirect()->route('fichas.envio')->with('mensagem', 'Status da turma alterado para: '.$request->get('opcao'));
    }
}
