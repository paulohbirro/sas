<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\MicroRegiaoRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\MicroRegiao;
use Illuminate\Support\Collection;

class MicroRegiaoEloquentRepository extends BaseEloquentRepository implements MicroRegiaoRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new MicroRegiao();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return MicroRegiaoRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
    }

    /**
     * Aplica condição no repositório para retornar apenas microregioes com avaliações
     *
     * @param null $like
     * @return MicroRegiaoRepository
     */
    public function hasAvaliacoes()
    {
        $this->model = $this->model->whereHas('avaliacoes', function(){});

        return $this;
    }


     /**
     * Aplica condição no repositório para retornar se exite dependências de registros entre Microregião->municipios->tecnicos
     *
     * @param int 
     * @return MicroRegiaoRepository
     */

    public function hasDpendencias($id){

        $retorno =   $this->model->with(array('municipios','tecnicos','turmas'))->find($id);   

        dd($retorno->Turma);

        $conta =  $retorno->municipios->count() + $retorno->tecnicos->count()+$retorno->Turma->cout();

        if($conta>0)
            return true;
        else
           return false;        
    }
}