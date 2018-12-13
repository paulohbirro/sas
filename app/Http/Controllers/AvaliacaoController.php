<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Facades\Sebrae;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class AvaliacaoController extends Controller
{

    protected $turmaRepositoy;

    /**
     * Constructor
     *
     * @param TurmaRepository $turmaRepository
     */
    public function __construct(TurmaRepository $turmaRepository)
    {
        $this->turmaRepositoy = $turmaRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        /*
         * Ordenação
         */
        $this->turmaRepositoy->order($request->get('by', 'inicio'), $request->get('order', 'DESC'));

        /*
         * Filtrar por periodo
         */
        $periodoDef = $request->get('periodoDef', 360);

        if($periodoDef=='PER')
            $this->turmaRepositoy->periodo($request->get('inicio'), $request->get('fim'));
        else
            $this->turmaRepositoy->ultimosDias($periodoDef);

        /*
         * Tecnico
         */
        if(Sebrae::is('Técnico de Microregião'))
            $this->turmaRepositoy->whereMicroRegiaoId(Sebrae::getDetalhes()->micro_regiao_id);
        else
            $this->turmaRepositoy->whereMicroRegiaoId($request->get('micro_regiao_id'));

        /*
         * Gerente
         */
        if(Sebrae::is('Gerente de Regional'))
            $this->turmaRepositoy->whereRegiaoId(Sebrae::getDetalhes()->regiao_id);
        else
            $this->turmaRepositoy->whereRegiaoId($request->get('regiao_id'));

        /*
         * Resultado
         */
        $turmas = $this->turmaRepositoy
            ->where([
                'status' => 'PUBLICADO',
                'municipio_id' => $request->get('municipio_id'),
                'solucao_id' => $request->get('solucao_id'),
                'consultor_id' => Sebrae::is('Consultor') ? Sebrae::getDetalhes()->id : $request->get('consultor_id')
            ])
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('avaliacao.index')->with(compact('turmas', 'periodoDef'));
    }

    /**
     * Ver
     *
     * @param String $codigoTurma
     */
    public function ver($codigoTurma, $aba = null)
    {
        if(is_null($aba))
            return redirect()->route('avaliacoes.ver', ['codigoTurma' => $codigoTurma, 'aba' => 'visaoGeral']);

        if(Sebrae::is('Consultor') && $aba != 'consultor' && $aba != 'comentarios')
            return redirect()->route('avaliacoes.ver', ['codigoTurma' => $codigoTurma, 'aba' => 'consultor']);

        $turma = $this->turmaRepositoy->getByCodigo($codigoTurma);

        if($aba == 'comentarios')
        {
            $tipos = Sebrae::is('Consultor') ? ['CONSULTOR'] : ['TODOS', 'NPS', 'CONSULTOR', 'METODOLOGIA', 'ATENDIMENTO'];

            $comentarios = $turma->avaliacao->comentarios;

            if(Sebrae::is('Consultor'))
            {
                $comentarios = $comentarios->filter(function($item){
                    return strpos($item->comentario_tags, 'CONSULTOR') !== false;
                });
            }

            if(Input::has('comentarioId'))
                $comentario = $comentarios->where('id', intval(Input::get('comentarioId')))->first();
            else
                $comentario = $comentarios->first();
        }

        return view('avaliacao.abas.'.$aba)->with(compact('turma', 'aba', 'comentario', 'comentarios', 'tipos'));
    }

    /**
     * Comentário
     *
     * @param Request $request
     */
    public function comentario($avaliacaoComentarioId, AvaliacaoComentarioRepository $avaliacaoComentarioRepository)
    {
        $comentario = $avaliacaoComentarioRepository->getById($avaliacaoComentarioId);

        return response(Storage::disk('digitalizacoes')->get($comentario->comentario_path), 200)->header('Content-Type', 'image/jpeg');
    }

    /**
     * Transcrição Comentario
     *
     * @param Request $request
     */
    public function transcricaoComentario($avaliacaoComentarioId, AvaliacaoComentarioRepository $avaliacaoComentarioRepository, Request $request)
    {
        $comentario = $avaliacaoComentarioRepository->getById($avaliacaoComentarioId);

        $comentario->update([
            'comentario_transcrito' => $request->get('transcricao', ''),
            'comentario_tags' => $request->has('tags') ? implode(',', $request->get('tags')) : ''
        ]);

        return redirect()->back();
    }
}
