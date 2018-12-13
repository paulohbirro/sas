<?php

use App\Eloquent\Models\Avaliacao;
use App\Eloquent\Models\Consultor;
use App\Eloquent\Models\GerenteGestor;
use App\Eloquent\Models\Gestor;
use App\Eloquent\Models\MicroRegiao;
use App\Eloquent\Models\Municipio;
use App\Eloquent\Models\Regiao;
use App\Eloquent\Models\Solucao;
use App\Eloquent\Models\Turma;
use App\Eloquent\Models\Unidade;
use Illuminate\Database\Seeder;

class TurmasExportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = __DIR__.'/sas_turmas_export.csv';

        $progressBar = $this->command->getOutput()->createProgressBar(count(file($path)));

        if (($handle = fopen($path, "r")) !== FALSE)
        {
            $row = 0;
            $head = null;

            while (($line = fgetcsv($handle, 0, ",")) !== FALSE)
            {
                if ($row != 0)
                {
                    /*
                     * Inicio
                     */

                    $data = array_combine($head, array_values($line));

                    $regiao = Regiao::firstOrCreate(['nome' => $data['regiao']]);
                    $microregiao = MicroRegiao::firstOrCreate(['nome' => $data['microregiao'], 'regiao_id' => $regiao->id]);
                    $municipio = Municipio::firstOrCreate(['nome' => $data['municipio'], 'micro_regiao_id' => $microregiao->id]);

                    $consultor = Consultor::firstOrCreate([
                        'nome' => $data['consultor_nome'],
                        'cpf' => $data['consultor_cpf'],
                        'user_ad' => $data['consultor_user_ad']==''?null:$data['consultor_user_ad'],
                        'tipo' => $data['consultor_tipo'],
                        'senha' => $data['consultor_senha']==''?null:$data['consultor_senha'],
                        'email' => $data['consultor_email']==''?null:$data['consultor_email']
                    ]);

                    $gerenteGestor = GerenteGestor::firstOrCreate(['nome' => $data['gerente_gestor_nome'], 'user_ad' => $data['gerente_gestor_user_ad']]);
                    $unidade = Unidade::firstOrCreate(['nome' => $data['unidade_gestor']]);

                    $gestor = Gestor::firstOrCreate(['nome' => $data['solucao_gestor'], 'user_ad' => $data['solucao_gestor_user_ad'], 'gerente_gestor_id' => $gerenteGestor->id, 'unidade_id' => $unidade->id]);
                    $solucao = Solucao::firstOrCreate(['nome' => $data['solucao'], 'gestor_id' => $gestor->id]);

                    $turma = Turma::create([
                        'codigo' => $data['﻿"codigo"'],
                        'inicio' => $data['inicio'],
                        'fim' => $data['fim'],
                        'vagas' => $data['vagas'],
                        'participantes' => $data['participantes'],
                        'local_execucao' => $data['local_execucao'],
                        'endereco_execucao' => $data['endereco_execucao'],
                        'status' => $data['status'],
                        'consultor_id' => $consultor->id,
                        'solucao_id' => $solucao->id,
                        'municipio_id' => $municipio->id,
                        'status' => 'PUBLICADO'
                    ]);

                    Avaliacao::create([
                        'turma_id' => $turma->id,
                        'quantidade' => $data['qtd_avaliacoes'],
                        'digitalizado' => $data['qtd_avaliacoes'],
                        'detratores' => $data['detratores'],
                        'passivos' => $data['passivos'],
                        'promotores' => $data['promotores'],
                        'nps' => $this->toFloat($data['nps']),
                        'nota_consultor' => $this->toFloat($data['nota_consultor']),
                        'nota_consultor_dominio' => $this->toFloat($data['nota_consultor_dominio']),
                        'nota_consultor_clareza' => $this->toFloat($data['nota_consultor_clareza']),
                        'nota_consultor_recursos' => $this->toFloat($data['nota_consultor_recursos']),
                        'nota_consultor_exemplos' => $this->toFloat($data['nota_consultor_exemplos']),
                        'nota_metodologia' => $this->toFloat($data['nota_metodologia']),
                        'nota_metodologia_duracao' => $this->toFloat($data['nota_metodologia_duracao']),
                        'nota_metodologia_material' => $this->toFloat($data['nota_metodologia_material']),
                        'nota_atendimento' => $this->toFloat($data['nota_atendimento']),
                        'nota_atendimento_prestado' => $this->toFloat($data['nota_atendimento_prestado']),
                        'nota_atendimento_ambiente' => $this->toFloat($data['nota_atendimento_ambiente']),
                        'status' => 'PROCESSADO'
                    ]);

                    $progressBar->advance();

                } else
                    $head = $line;

                $row++;
            }

            fclose ($handle);
            $progressBar->finish();
        }

    }

    private function toFloat($string_number){
        return floatval(str_replace(',', '.', str_replace('.', '', $string_number)));
    }
}
