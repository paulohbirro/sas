<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\AvaliacaoFichaRepository;
use App\Contracts\Repositories\AvaliacaoPerguntaRepository;
use App\Contracts\Repositories\AvaliacaoRepository;
use App\Contracts\Repositories\AvaliacaoRespostaRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Http\Requests\DigitalizacaoUpload;
use App\Jobs\Scan;
use App\SyncTurma;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Intervention\Image\Facades\Image;

class DigitalizacaoController extends Controller
{

    protected $avaliacaoRepository;
    protected $avaliacaoPerguntaRepository;
    protected $avaliacaoFichaRepository;
    protected $avaliacaoComentarioRepository;
    protected $turmaRepository;

    /**
     * Constructor
     *
     * @param AvaliacaoRepository $avaliacaoRepository
     */
    public function __construct(AvaliacaoRepository $avaliacaoRepository, TurmaRepository $turmaRepository, AvaliacaoFichaRepository $avaliacaoFichaRepository, AvaliacaoPerguntaRepository $avaliacaoPerguntaRepository, AvaliacaoComentarioRepository $avaliacaoComentarioRepository)
    {
        $this->avaliacaoRepository = $avaliacaoRepository;
        $this->avaliacaoPerguntaRepository = $avaliacaoPerguntaRepository;
        $this->avaliacaoFichaRepository = $avaliacaoFichaRepository;
        $this->avaliacaoComentarioRepository = $avaliacaoComentarioRepository;
        $this->turmaRepository = $turmaRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->avaliacaoRepository->order($request->get('by', 'created_at'), $request->get('order', 'DESC'));

        //Resultado
        $avaliacoes = $this->avaliacaoRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('digitalizacao.index')->with(compact('avaliacoes'));
    }

    /**
     * Ver
     *
     * @param Request $request
     */
    public function ver($avaliacaoId, $avaliacaoFichaId = null)
    {
        $avaliacao = $this->avaliacaoRepository->getById($avaliacaoId);
        $perguntas = $this->avaliacaoPerguntaRepository->order('id', 'asc')->all();

        if(!is_null($avaliacaoFichaId))
            $ficha = $this->avaliacaoFichaRepository->getById($avaliacaoFichaId);
        else
            $ficha = $avaliacao->fichas->first();

        return view('digitalizacao.ver')->with(compact('avaliacao', 'ficha', 'perguntas'));
    }

    /**
     * ficha
     *
     * @param Request $request
     */
    public function ficha($avaliacaoFichaId, Request $request)
    {
        $ficha = $this->avaliacaoFichaRepository->getById($avaliacaoFichaId);

        if($request->get('debug') == 'true')
            $img = Image::make(Storage::disk('digitalizacoes')->get($ficha->image_path.'.debug.jpg'));
        else
            $img = Image::make(Storage::disk('digitalizacoes')->get($ficha->image_path));

        return $img->response('jpg');
    }

    /**
     * comentario
     *
     * @param Request $request
     */
    public function comentario($avaliacaoComentarioId)
    {
        $comentario = $this->avaliacaoComentarioRepository->getById($avaliacaoComentarioId);

        if(Storage::disk('digitalizacoes')->has($comentario->comentario_path))
            return Image::make(Storage::disk('digitalizacoes')->get($comentario->comentario_path))->response('jpg');
    }


    /**
     * Deletar Comentario
     *
     * @param Request $request
     */
    public function deletarComentario($avaliacaoComentarioId)
    {
        $comentario = $this->avaliacaoComentarioRepository->getById($avaliacaoComentarioId);

        $comentario->delete();

        return redirect()->back();
    }

    /**
     * Enviar comentario
     *
     * @param Request $request
     */
    public function uploadComentario($avaliacaoFichaId, Request $request)
    {
        $ficha = $this->avaliacaoFichaRepository->getById($avaliacaoFichaId);

        $file = $request->file('croppedImage');

        $comentario = $ficha->comentario;

        if(!is_null($comentario))
        {
            $comentario->delete();
            Storage::disk('digitalizacoes')->delete($comentario->comentario_path);
        }

        Storage::disk('digitalizacoes')->put($ficha->image_path.'.comentario.jpg', file_get_contents($file->getRealPath()));

        $this->avaliacaoComentarioRepository->save([
            'avaliacao_id' => $ficha->avaliacao->id,
            'avaliacao_ficha_id' => $ficha->id,
            'comentario_path' => $ficha->image_path.'.comentario.jpg'
        ]);
    }


    /**
     * Upload
     *
     * @param Request $request
     */
    public function upload(DigitalizacaoUpload $request)
    {
        $file = $request->file('file');

        $storagePath = Storage::disk('digitalizacoes')->getDriver()->getAdapter()->getPathPrefix();

        $images = new Imagick($file->getRealPath());

        $codigo = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName());

        $aux = explode("_", $codigo);

        if($aux>0)
            $codigo = $aux[0];

        $turma = $this->turmaRepository->getByCodigo($codigo);

        if(is_null($turma))
        {
            try{
                $sync = new SyncTurma($codigo);
                $turma = $sync->getTurmaModel();
            }catch (Exception $e){
                return response()->json(['code' => 7, 'message' => "Turma $codigo nao encontrada!"]);
            }
        }

        if(is_null($turma->avaliacao))
            $avaliacao = $this->avaliacaoRepository->save(['turma_id' => $turma->id]);
        else
            return response()->json(['code' => 8, 'message' => "Fichas da Turma $codigo já foi digitalizada!"]);

        try{

            $imageDirPath = Carbon::now()->format('Y-m').DIRECTORY_SEPARATOR.$codigo.DIRECTORY_SEPARATOR;

            Storage::disk('digitalizacoes')->makeDirectory($imageDirPath);

            $count = 0;

            $steve = [];

            foreach($images as $i => $image)
            {
                $filename = $imageDirPath.Carbon::now()->format('dHis').'-'.$i.'.jpg';

                $image->writeImage($storagePath.$filename);

                $ficha = $this->avaliacaoFichaRepository->save([
                    'avaliacao_id' => $avaliacao->id,
                    'image_path' => $filename
                ]);

                $steve[] = new Scan($ficha);

                $count++;
            }

            $this->avaliacaoRepository->save([
                'id' => $avaliacao->id,
                'quantidade' => $avaliacao->quantidade + $count
            ]);

            if($count == 0)
                throw new Exception('Erro no upload. Tente novamente');

            //Dispatch jobs! :-)
            foreach($steve as $jobs)
                $this->dispatch($jobs);

        }catch (Exception $e){

            Log::info($e);

            $this->avaliacaoRepository->save([
                'id' => $avaliacao->id,
                'status' => 'ERRO',
                'erro' => $e->getMessage()
            ]);
        }

        return response()->json(['code' => 0, 'message' => "Enviado com sucesso! Processando .."]);
    }

    public function atualizarResposta($avaliacaoFichaId, Request $request, AvaliacaoRespostaRepository $avaliacaoRespostaRepository)
    {
        $avaliacao_pergunta_id = $request->get('avaliacao_pergunta_id');
        $resposta = $request->get('resposta');

        if($resposta == 'null')
            $resposta = null;

        $avaliacaoFicha = $this->avaliacaoFichaRepository->getById($avaliacaoFichaId);

        $avaliacaoFicha->update(['status' => 'PROCESSANDO']);

        $respostas = $avaliacaoFicha->respostas->filter(function($item) use ($avaliacao_pergunta_id){
            return ($item->avaliacao_pergunta_id == $avaliacao_pergunta_id) || ($item->avaliacao_pergunta_id == intval($avaliacao_pergunta_id));
        });

        $avaliacaoResposta = $respostas->first();

        if(is_null($avaliacaoResposta))
        {
            $avaliacaoRespostaRepository->save([
                'avaliacao_ficha_id' => $avaliacaoFicha->id,
                'avaliacao_pergunta_id' => $avaliacao_pergunta_id,
                'resposta' => $resposta,
                'manual'  => true
            ]);

        }else
            $avaliacaoResposta->update(['resposta' => $resposta, 'manual' => true]);

        $avaliacaoFicha->update(['status' => 'PROCESSADO']);

        return response()->json(['code' => 0, 'message' => 'Resposta atualizada com sucesso!']);
    }

    /**
     * Ver
     *
     * @param Request $request
     */
    public function excluir($avaliacaoId)
    {
        $avaliacao = $this->avaliacaoRepository->getById($avaliacaoId);
        $turma = $avaliacao->turma;

        //Removendo arquivos
        foreach($avaliacao->fichas as $ficha)
        {
            if(Storage::disk('digitalizacoes')->has($ficha->image_path))
                Storage::disk('digitalizacoes')->delete($ficha->image_path);

            if(Storage::disk('digitalizacoes')->has($ficha->image_path.'.debug.jpg'))
                Storage::disk('digitalizacoes')->delete($ficha->image_path.'.debug.jpg');

            if(Storage::disk('digitalizacoes')->has($ficha->image_path.'.comentario.jpg'))
                Storage::disk('digitalizacoes')->delete($ficha->image_path.'.comentario.jpg');
        }

        //Removendo avaliacao
        $this->avaliacaoRepository->remove($avaliacaoId);

        //Atualizando status da turma
        $turma->status = 'ENVIADO';
        $turma->save();

        return redirect()->back()->withErrors("Digitalização da turma [$turma->codigo] excluida com sucesso.");
    }
}
