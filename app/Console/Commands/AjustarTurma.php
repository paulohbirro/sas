<?php

namespace App\Console\Commands;

use App\Eloquent\Models\Municipio;
use App\SyncTurma;
use Exception;
use Illuminate\Console\Command;

class AjustarTurma extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sas:ajustar-turma {codigo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando verifica efetua sincronização de uma determinada turma.';

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
    public function handle()
    {
        /*
         * sincronizando
         */
        try{

            $sync = new SyncTurma($this->argument('codigo'));

            $turma = $sync->getTurmaModel();

            dump([
                'id' => $turma->id,
                'codigo' => $turma->codigo,
                'municipio' => $turma->municipio->nome,
                'micro_regiao' => $turma->municipio->microRegiao->nome,
                'regiao' => $turma->municipio->microRegiao->regiao->nome
            ]);

        } catch (Exception $e){
            $this->error($e->getMessage());
        }
    }
}
