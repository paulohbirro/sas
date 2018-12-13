<?php

namespace App\Jobs;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\AvaliacaoPerguntaRepository;
use App\Contracts\Repositories\AvaliacaoRespostaRepository;
use App\Eloquent\Models\AvaliacaoFicha;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use JansenFelipe\OMR\Maps\MapJson;
use JansenFelipe\OMR\Scanners\ImagickScanner;
use JansenFelipe\OMR\Targets\TextTarget;

class Scan extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $ficha;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AvaliacaoFicha $ficha)
    {
        $this->ficha = $ficha;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AvaliacaoPerguntaRepository $avaliacaoPerguntaRepository, AvaliacaoRespostaRepository $avaliacaoRespostaRepository, AvaliacaoComentarioRepository $avaliacaoComentarioRepository)
    {

        DB::reconnect(env('DB_CONNECTION', 'mysql'));

        $storagePath  = Storage::disk('digitalizacoes')->getDriver()->getAdapter()->getPathPrefix();
        $imagePath = $storagePath.$this->ficha->image_path;

        $scanner = new ImagickScanner();
        $scanner->setDebug(true);
        $scanner->setImagePath($imagePath);
        $scanner->setDebugPath($imagePath.'.debug.jpg');

        $map = MapJson::create(storage_path('mark.json'));

        $result = $scanner->scan($map);

        $respostas = [];
        $percentuais = [];

        foreach($result->getTargets() as $target)
        {
            if($target instanceof TextTarget)
            {
                $comentarioPath = $this->ficha->image_path.'.comentario.jpg';

                Storage::disk('digitalizacoes')->put($comentarioPath, $target->getImageBlob());

                $avaliacaoComentarioRepository->save([
                    'avaliacao_id' => $this->ficha->avaliacao->id,
                    'avaliacao_ficha_id' => $this->ficha->id,
                    'comentario_path' => $comentarioPath
                ]);

            }else{

                if($target->isMarked())
                {
                    $aux = explode('_', $target->getId());

                    $respostas[$aux[0]][] = $aux[1];
                    $percentuais[$aux[0]][] = $target->getBlackPixelsPercent();
                }

            }
        }

        foreach ($avaliacaoPerguntaRepository->all() as $pergunta)
        {
            if(isset($respostas[$pergunta->numero]))
            {
                $r = $respostas[$pergunta->numero];

                if(count($r) == 1)
                    $resposta = $r[0];

                else{
                    $p = $percentuais[$pergunta->numero];

                    arsort($p);

                    $p_first = array_slice($p, 0, 1);
                    $p_second = array_slice($p, 1, 1);

                    if(in_array($pergunta->id, [2,3,4,5]))
                    {

                        if(($p_first[0] - $p_second[0]) <= 3.3)
                            continue;

                    }else{

                        if(($p_first[0] - $p_second[0]) <= 2)
                            continue;
                    }


                    $key = array_search($p_first[0], $p);

                    $resposta = $r[$key];
                }

                $avaliacaoRespostaRepository->save([
                    'avaliacao_ficha_id' => $this->ficha->id,
                    'avaliacao_pergunta_id' => $pergunta->id,
                    'resposta' => $resposta,
                    'manual' => false
                ]);
            }
        }

        $this->ficha->update(['status' => 'PROCESSADO']);
    }
}
