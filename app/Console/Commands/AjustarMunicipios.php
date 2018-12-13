<?php

namespace App\Console\Commands;

use App\Eloquent\Models\Municipio;
use App\SyncTurma;
use Exception;
use Illuminate\Console\Command;

class AjustarMunicipios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sas:ajustar-municipios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando verifica todas os municípios no banco de dados e refaz a sincronização par atualizar os dados.';

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
        $municipios = Municipio::orderBy('nome')->get();

        $progressbar = $this->output->createProgressBar(count($municipios));

        /*
         * Verificando municipios
         */
        $municipios->each(function(Municipio $municipio) use ($progressbar)
        {
            $progressbar->advance();

            /*
             * Pegando primeira turma de uma municipio
             */
            $turma = $municipio->turmas->first();

            if(is_null($turma))
            {
                $this->error("Município não possui turma.");
                return;
            }

            /*
             * sincronizando
             */
            try{

                $sync = new SyncTurma($turma->codigo);

                $turma = $sync->getTurmaModel();

                $this->warn(" Updated: " . $turma->municipio->nome . " (Microregiao: " .$turma->municipio->microRegiao->nome . " / Regiao: " .$turma->municipio->microRegiao->regiao->nome . ")");

            } catch (Exception $e){
                $this->error($e->getMessage());
            }
        });

        $progressbar->finish();
    }
}
