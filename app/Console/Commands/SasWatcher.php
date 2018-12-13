<?php

namespace App\Console\Commands;

use App\Contracts\Repositories\AvaliacaoFichaRepository;
use App\Contracts\Repositories\AvaliacaoRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Jobs\Scan;
use App\SyncTurma;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Imagick;
use JasonLewis\ResourceWatcher\Resource\FileResource;
use JasonLewis\ResourceWatcher\Watcher;

class SasWatcher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sas:watcher {dir}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica no diretório informado se foi criada uma digitalização (.tif) para processar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Watcher $watcher, TurmaRepository $turmaRepository, AvaliacaoRepository $avaliacaoRepository, AvaliacaoFichaRepository $avaliacaoFichaRepository)
    {
        $dir = $this->argument('dir');

        if(!File::isDirectory($dir))
        {
            $this->error('Informe um diretório válido!');
            return;
        }

        /*
         * Informando diretorio a ser assitido
         */
        $listener = $watcher->watch($dir);

        /*
         * Evento a ser disparado quando um arquivo for criado
         */
        $listener->onCreate(function(FileResource $resource, $path) use ($turmaRepository, $avaliacaoRepository, $avaliacaoFichaRepository)
        {
            try{
                /*
                 * Verificando se é um arquivo de imagem .tif
                 */
                if($resource->getSplFileInfo()->getExtension() != 'tif')
                    return;

                $this->info("O arquivo '$path' foi criado");

                /*
                 * Criando o Imagick
                 */
                $images = new Imagick($path);

                /*
                 * Descobrindo código da turma pelo nome do arquivo
                 */
                $filename = $resource->getSplFileInfo()->getFilename();
                $codigo = explode('_', $filename)[0];

                $this->info("Pesquisando turma com o código: $codigo");

                $turma = $turmaRepository->getByCodigo($codigo);

                /*
                 * Se turma não existe, tenta sincronizar com o Sistema de Planejamento/SIV
                 */
                if(is_null($turma))
                {
                    $this->info("Turma nao encontrada.. tentando encontrar no Sistema de Planejamento/SIV: $codigo");

                    $turma = (new SyncTurma($codigo))->getTurmaModel();
                }

                /*
                 * Verifica se já existe avaliação para a turma
                 */
                if(!is_null($turma->avaliacao))
                    throw new Exception("Avaliacoes da turma $codigo ja foram enviadas");

                /*
                 * Criando uma avaliação para a turma e um diretório para armazenar as fichas
                 */
                $now = Carbon::now();

                $avaliacao = $avaliacaoRepository->save(['turma_id' => $turma->id]);
                $imageDirPath = $now->format('Y-m') . DIRECTORY_SEPARATOR . $codigo . DIRECTORY_SEPARATOR;
                Storage::disk('digitalizacoes')->makeDirectory($imageDirPath);

                $this->info("Avaliaçao [".$avaliacao->id."] foi criada para turma.. Adicionando fichas..");

                /*
                 * Lendo o arquivo, salvando as fichas e criando os jobs
                 */
                $storagePath = Storage::disk('digitalizacoes')->getDriver()->getAdapter()->getPathPrefix();

                $count = 0;

                foreach($images as $i => $image)
                {
                    $filename = $imageDirPath . $now->format('dHis').'-'.$i.'.jpg';

                    $image->writeImage($storagePath . $filename);

                    $ficha = $avaliacaoFichaRepository->save([
                        'avaliacao_id' => $avaliacao->id,
                        'image_path' => $filename
                    ]);

                    Queue::push(new Scan($ficha));

                    $this->info("Ficha adicionada [".$ficha->id."] !");

                    $count++;
                }

                /*
                 * Atualizando a quantidade de fichas encontradas
                 */
                $avaliacaoRepository->save([
                    'id' => $avaliacao->id,
                    'quantidade' => $avaliacao->quantidade + $count
                ]);

            }catch (Exception $e){
                $this->info($e->getMessage());
            }
        });

        /*
         * Iniciando o watcher (default: a cada 1 segundo)
         */
        $watcher->start();
    }

    /**
     * Write a string as information output.
     *
     * @param  string  $string
     * @return void
     */
    public function info($string)
    {
        Log::info($string);

        parent::info($string);
    }
}
