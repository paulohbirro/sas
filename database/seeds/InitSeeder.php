<?php

use App\Eloquent\Models\AvaliacaoPergunta;
use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AvaliacaoPergunta::create(['numero' => 'a',  'pergunta' => '1) Desempenho geral do consultor / instrutor que ministrou a capacitação', 'opcoes' => 11]);

        AvaliacaoPergunta::create(['numero' => 'ba', 'pergunta' => '2.a) Domínio do conteúdo pelo consultor / instrutor', 'opcoes' => 5]);
        AvaliacaoPergunta::create(['numero' => 'bb', 'pergunta' => '2.b) Clareza e objetividade no repasse das informações', 'opcoes' => 5]);
        AvaliacaoPergunta::create(['numero' => 'bc', 'pergunta' => '2.c) Utilização de recursos que estimularam a participação e facilitaram o aprendizado dos alunos', 'opcoes' => 5]);
        AvaliacaoPergunta::create(['numero' => 'bd', 'pergunta' => '2.d) Utilização de exemplos e ferramentas práticas aplicáveis a realidade das micro e pequenas empresas', 'opcoes' => 5]);

        AvaliacaoPergunta::create(['numero' => 'ca', 'pergunta' => '3.1) Material didático utilizado', 'opcoes' => 11]);
        AvaliacaoPergunta::create(['numero' => 'cb', 'pergunta' => '3.2) Adequação da carga horária ao conteúdo', 'opcoes' => 11]);
        AvaliacaoPergunta::create(['numero' => 'cc', 'pergunta' => '3.3) Infraestrutura utilizada', 'opcoes' => 11]);
        AvaliacaoPergunta::create(['numero' => 'cd', 'pergunta' => '3.4) Atendimento prestado pelo Sebrae antes e durante a capacitação', 'opcoes' => 11]);

        AvaliacaoPergunta::create(['numero' => 'd',  'pergunta' => '4) Chance de indicar para outras pessoas este treinamento / capacitação', 'opcoes' => 11]);
    }
}
