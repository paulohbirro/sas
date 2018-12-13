<?php

namespace App;

use App\Eloquent\Models\Consultor;
use App\Eloquent\Models\GerenteGestor;
use App\Eloquent\Models\GerenteRegiao;
use App\Eloquent\Models\Gestor;
use App\Eloquent\Models\MicroRegiao;
use App\Eloquent\Models\Municipio;
use App\Eloquent\Models\Regiao;
use App\Eloquent\Models\Solucao;
use App\Eloquent\Models\Tecnico;
use App\Eloquent\Models\Turma;
use App\Eloquent\Models\Unidade;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use PDO;
use SimpleXMLElement;

class SyncTurma
{
    /**
     * Turma Eloquent Model
     *
     * @var Turma
     */
    private $turmaModel;

    /**
     * Turma XML
     *
     * @var SimpleXMLElement
     */
    private $turmaXML;

    /**
     * Construtor
     *
     * @param string $codigo
     */
    public function __construct($codigo)
    {
        if(!ctype_digit($codigo))
            throw new Exception("Código da turma $codigo não é valido ");

        try{
            $content = file_get_contents(env('URL_PLANEJAMENTO').'?cdn_turma='. $codigo);

            $lines = explode("\n", $content);
            $xmlStr = implode("\n", array_slice($lines, 2));
            $xmlStr = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $xmlStr);

            $this->turmaXML = simplexml_load_string($xmlStr)->turma;

        }catch (Exception $e){
            Log::info($e->getMessage());
            throw new Exception("Erro ao consultar no Sistema de Planejamento. Verifique se existe o código $codigo");
        }
    }

    /**
     * Turma XML
     *
     * @return SimpleXMLElement
     */
    public function getTurmaXML()
    {
        return $this->turmaXML;
    }

    /**
     * Turma Eloquent Model
     *
     * @return Turma
     */
    public function getTurmaModel()
    {
        /*
         * Regiao
         */
        $regiao = Regiao::firstOrCreate(['nome' => $this->turmaXML->municipio->microregiao->regiao->nome]);

        /*
         * Microregiao
         */
        if(empty((string) $this->turmaXML->municipio->microregiao->nome))
            throw new Exception("Não foi possível recuperar a microrregiao da turma " . $this->turmaXML->attributes()->id . ". Verifique os cadastros no ERP");

        $microregiao = MicroRegiao::where('nome', $this->turmaXML->municipio->microregiao->nome)->first();

        if(is_null($microregiao))
        {
            $microregiao = new MicroRegiao();
            $microregiao->nome = $this->turmaXML->municipio->microregiao->nome;
        }

        $microregiao->regiao_id = $regiao->id;
        $microregiao->save();

        /*
         * Municipio
         */
        $municipio = Municipio::where('nome', $this->turmaXML->municipio->nome)->first();

        if(is_null($municipio))
        {
            $municipio = new Municipio();
            $municipio->nome = $this->turmaXML->municipio->nome;
        }

        $municipio->micro_regiao_id = $microregiao->id;
        $municipio->save();

        /*
         * Tecnico
         */
        $tecnico = Tecnico::where(['user_ad' => $this->turmaXML->municipio->microregiao->tecnico->user])->first();

        if(is_null($tecnico))
        {
            $tecnico = new Tecnico();
            $tecnico->user_ad = $this->turmaXML->municipio->microregiao->tecnico->user;
        }

        $tecnico->nome = $this->turmaXML->municipio->microregiao->tecnico->nome;
        $tecnico->micro_regiao_id = $microregiao->id;
        $tecnico->save();

        /*
         * Gerente região
         */
        $gerenteRegiao = GerenteRegiao::where(['user_ad' => $this->turmaXML->municipio->microregiao->regiao->gerente->user])->first();

        if(is_null($gerenteRegiao))
        {
            $gerenteRegiao = new GerenteRegiao();
            $gerenteRegiao->user_ad = $this->turmaXML->municipio->microregiao->regiao->gerente->user;
        }

        $gerenteRegiao->nome = $this->turmaXML->municipio->microregiao->regiao->gerente->nome;
        $gerenteRegiao->regiao_id = $regiao->id;
        $gerenteRegiao->save();

        /*
         * Consultor
         */
        $consultor = Consultor::where('cpf', $this->turmaXML->consultor->documento)->first();

        if(is_null($consultor))
        {
            $consultor = new Consultor();
            $consultor->cpf = $this->turmaXML->consultor->documento;
        }

        $consultor->nome = $this->turmaXML->consultor->nome;
        $consultor->user_ad = ($this->turmaXML->consultor->{"tpo-consultor"}=='interno' && strlen($this->turmaXML->consultor->user)>0)?$this->turmaXML->consultor->user:null;
        $consultor->tipo = $this->turmaXML->consultor->{"tpo-consultor"};
        $consultor->save();

        /*
         * Gestor
         */
        $gestor = Gestor::where('user_ad', (string) $this->turmaXML->solucao->gestor->user)->first();

        if(is_null($gestor))
        {
            $gestor = new Gestor();
            $gestor->user_ad = (string) $this->turmaXML->solucao->gestor->user;
        }

        $gestor->nome = (string) $this->turmaXML->solucao->gestor->nome;
        $gestor->save();

        /*
         * Unidade/Gerente
         */
        if(strlen($this->turmaXML->solucao->gestor->documento) == 11)
        {
            $documento = (string) $this->turmaXML->solucao->gestor->documento;

            /*
             * Consultando no SQLSERVER
             */
            $pdo = new PDO(getenv('PDO_MSSQL_DSN'), getenv('PDO_MSSQL_USERNAME'), getenv('PDO_MSSQL_PASSWORD'));

            $sth = $pdo->prepare("SELECT u.DESCRICAO as unidade,
                                         gp.NOME as gerente,
                                         gp.CODUSUARIO as gerente_user
                                  FROM CORPORERM.DBO.PFUNC AS f (NOLOCK) 
                                  INNER JOIN CORPORERM.DBO.PPESSOA AS fp (NOLOCK) ON f.CODPESSOA = fp.CODIGO
                                  INNER JOIN CORPORERM.DBO.PSECAO AS u (NOLOCK) ON (f.CODCOLIGADA = u.CODCOLIGADA AND f.CODSECAO = u.CODIGO)
                                  INNER JOIN CORPORERM.DBO.PSUBSTCHEFE AS PSUBSTCHEFE (NOLOCK) ON (f.CODCOLIGADA = PSUBSTCHEFE.CODCOLIGADA AND f.CODSECAO = PSUBSTCHEFE.CODSECAO)
                                  INNER JOIN CORPORERM.DBO.PFUNC AS g (NOLOCK) ON (g.CODCOLIGADA = PSUBSTCHEFE.CODCOLIGADA AND g.CHAPA = PSUBSTCHEFE.CHAPASUBST AND PSUBSTCHEFE.DATAFIM IS NULL)
                                  INNER JOIN CORPORERM.DBO.PPESSOA AS gp (NOLOCK) ON g.CODPESSOA = gp.CODIGO
                                  WHERE fp.CPF = '$documento'");
            $sth->execute();
            $row = $sth->fetch();

            if($row != false){ 
            
                /*
                * Gerente do gestor
                */
                $gerente = GerenteGestor::where('user_ad', $row['gerente_user'])->first();

                if(is_null($gerente))
                    $gerente = new GerenteGestor();

                $gerente->fill([
                    'nome' => $row['gerente'],
                    'user_ad' => $row['gerente_user']
                ]);

                $gerente->save();

                /*
                * Unidade
                */
                $unidade = Unidade::firstOrCreate(['nome' => $row['unidade']]);

                /*
                * Atualizando gestor
                */
                $gestor->update([
                    'gerente_gestor_id' => $gerente->id,
                    'unidade_id' => $unidade->id
                ]);
            }
        }

        /*
         * Solução
         */
        $solucao = Solucao::where(['nome' => $this->turmaXML->solucao->nome])->first();

        if(is_null($solucao))
        {
            $solucao = new Solucao();
            $solucao->nome = $this->turmaXML->solucao->nome;
        }

        $solucao->gestor_id = $gestor->id;
        $solucao->save();

        /*
         * Verificando se existe a turma
         */
        $turma = Turma::where('codigo', (string) $this->turmaXML->attributes()->id)->first();

        $params = [
            'codigo' => (string) $this->turmaXML->attributes()->id,
            'inicio' => Carbon::createFromFormat('d/m/Y H:i', (string) $this->turmaXML->{"data-ini"}),
            'fim' => Carbon::createFromFormat('d/m/Y H:i', (string) $this->turmaXML->{"data-fim"}),
            'vagas' => (string) $this->turmaXML->{"qtd-vagas"},
            'participantes' => (string) $this->turmaXML->{"qtd-particip"},
            'local_execucao' => (string) $this->turmaXML->{"local-realiz"},
            'endereco_execucao' => (string) $this->turmaXML->{"ender-realiz"},
            'consultor_id' => $consultor->id,
            'solucao_id' => $solucao->id,
            'municipio_id' => $municipio->id
        ];

        if(is_null($turma))
            $turma = Turma::create($params);
        else
            $turma->update($params);

        return $turma;
    }
}