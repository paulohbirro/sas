<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\RegiaoRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Regiao;

class RegiaoEloquentRepository extends BaseEloquentRepository implements RegiaoRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Regiao();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return RegiaoEloquentRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
    }


    public function find($id){

         $this->model = $this->model->find($id); 

         return $this;       


    }   

     public function hasDpendencias($id){

      
        $retorno =   $this->model->with(array('microregioes','municipios','gerentes','turmas'))->find($id); 
        $conta =  $retorno->microregioes->count() + $retorno->municipios->count()+$retorno->gerentes->count()+$retorno->turmas->count();

        if($conta>0)
            return true;
        else
           return false;        
    }





}