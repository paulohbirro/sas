<?php

namespace App\Console\Commands;

use App\Eloquent\Models\Solucao;
use App\SyncTurma;
use Exception;
use Illuminate\Console\Command;

class AjustarSolucoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sas:ajustar-solucoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando verifica todas as soluções no banco de dados e refaz a sincronização par atualizar os gestores.';

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
        $solucoes = Solucao::all();

        $progressbar = $this->output->createProgressBar(count($solucoes));

        /*
         * Verificando solucoes
         */
        $solucoes->each(function(Solucao $solucao) use ($progressbar)
        {
            $progressbar->advance();

            $this->info(PHP_EOL . "Solução: " . $solucao->nome . " (Gestor: " . $solucao->gestor->nome . ")");

            /*
             * Pegando primeira turma de uma solução
             */
            $turma = $solucao->turmas->first();

            if(is_null($turma))
            {
                $this->error("Solução não possui turma.");
                return;
            }

            /*
             * sincronizando
             */
            try{

                $sync = new SyncTurma($turma->codigo);

                $turma = $sync->getTurmaModel();

                $this->warn("Updated: " . $turma->solucao->nome . " (Gestor: " .$turma->solucao->gestor->nome . ")");

            } catch (Exception $e){
                $this->error($e->getMessage());
            }
        });

        $progressbar->finish();
    }
}
