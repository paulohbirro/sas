<?php

use App\Eloquent\Models\Admin;
use App\Eloquent\Models\Consultor;
use App\Eloquent\Models\Expedicao;
use App\Eloquent\Models\GerenteGestor;
use App\Eloquent\Models\GerenteRegiao;
use App\Eloquent\Models\Gestor;
use App\Eloquent\Models\MicroRegiao;
use App\Eloquent\Models\Regiao;
use App\Eloquent\Models\Tecnico;
use App\Eloquent\Models\Ued;
use App\Eloquent\Models\Ugp;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create(['nome' => 'Jansen Vitor', 'user_ad' => 'jansenv']);
        Admin::create(['nome' => 'Henrique Campos', 'user_ad' => 'henriquec']);
        Admin::create(['nome' => 'Helbert Thiago', 'user_ad' => 'helbertt']);
        Admin::create(['nome' => 'Carlos Denilson', 'user_ad' => 'carlosg']);
        Admin::create(['nome' => 'Márcia Cristiane', 'user_ad' => 'mcrist']);

        Ued::create(['nome' => 'Jansen Vitor', 'user_ad' => 'jansenv']);
        Ued::create(['nome' => 'Débora Elisa de Jesus', 'user_ad' => 'deboraj']);
        Ued::create(['nome' => 'Eduardo Caldeira Pimentel', 'user_ad' => 'eduardop']);
        Ued::create(['nome' => 'Elisa Nunes Fróes', 'user_ad' => 'elisaf']);
        Ued::create(['nome' => 'Raquel Jaques dos Santos Silvério', 'user_ad' => 'raquels']);
        Ued::create(['nome' => 'Vinicius da Silva Rodrigues', 'user_ad' => 'vinicius']);

        Ugp::create(['nome' => 'Jansen Vitor', 'user_ad' => 'jansenv']);
        Ugp::create(['nome' => 'Eduardo Correia Lopes dos Santos', 'user_ad' => 'eduardos']);
        Ugp::create(['nome' => 'Elisa Nunes Fróes', 'user_ad' => 'elisaf']);
        Ugp::create(['nome' => 'Eduardo Caldeira Pimentel', 'user_ad' => 'eduardop']);

        GerenteRegiao::create(['nome' => 'Jansen Vitor',                      'user_ad' => 'jansenv',  'regiao_id' => Regiao::where('nome', 'CENTRO')->first()->id]);
        GerenteRegiao::create(['nome' => 'Antônio Augusto Vianna de Freitas', 'user_ad' => 'freitas',  'regiao_id' => Regiao::where('nome', 'CENTRO')->first()->id]);
        GerenteRegiao::create(['nome' => 'Rogério Nunes Fernandes',           'user_ad' => 'rogeriof', 'regiao_id' => Regiao::where('nome', 'JEQUITINHONHA MUCURI')->first()->id]);
        GerenteRegiao::create(['nome' => 'Marcos Geraldo Alves da Silva',     'user_ad' => 'marcosg',  'regiao_id' => Regiao::where('nome', 'NOROESTE')->first()->id]);
        GerenteRegiao::create(['nome' => 'Cláudio Luiz de Souza Oliveira',    'user_ad' => 'claudios', 'regiao_id' => Regiao::where('nome', 'NORTE')->first()->id]);
        GerenteRegiao::create(['nome' => 'Fabrício César Fernandes',          'user_ad' => 'fabricic', 'regiao_id' => Regiao::where('nome', 'RIO DOCE')->first()->id]);
        GerenteRegiao::create(['nome' => 'Juliano Cornélio',                  'user_ad' => 'julianoc', 'regiao_id' => Regiao::where('nome', 'SUL')->first()->id]);
        GerenteRegiao::create(['nome' => 'William Rodrigues de Brito',        'user_ad' => 'williamr', 'regiao_id' => Regiao::where('nome', 'TRIANGULO')->first()->id]);
        GerenteRegiao::create(['nome' => 'João Roberto Marques Lobo',         'user_ad' => 'JOAOL',    'regiao_id' => Regiao::where('nome', 'ZONA DA MATA')->first()->id]);

        Expedicao::create(['nome' => 'Wemerson Sidnei Ribeiro do Nascimento', 'user_ad' => 'wemersons']);
        Expedicao::create(['nome' => 'Jansen Vitor', 'user_ad' => 'jansenv']);

        Tecnico::create(['nome' => 'Jansen Vitor', 'user_ad' => 'jansenv',  'micro_regiao_id' => MicroRegiao::where('nome', 'MR Capital')->first()->id]);

        Gestor::create(['nome' => 'Jansen Vitor', 'user_ad' => 'jansenv']);
        GerenteGestor::create(['nome' => 'Jansen Vitor', 'user_ad' => 'jansenv']);

        Consultor::create(['nome' => 'Jansen Vitor', 'user_ad' => 'jansenv', 'tipo' => 'interno']);
        Consultor::create(['nome' => 'Jansen Vitor', 'email' => 'jansen.vitor@sebraemg.com.br', 'cpf' => '06078437640', 'senha' => md5('jansen'), 'tipo' => 'externo']);
    }
}
