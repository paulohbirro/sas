<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\ConsultorRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Consultor;

class ConsultorEloquentRepository extends BaseEloquentRepository implements ConsultorRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Consultor();
    }

    /**
     * Retorna consultor a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD)
    {
        return $this->model()->where('user_ad', $userAD)->get();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return ConsultorEloquentRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
    }

    /**
     * Aplica condição no repositorio para considerar apenas consultores com avaliacao
     *
     * @return ConsultorEloquentRepository
     */
    public function comAvaliacao()
    {
        $this->model = $this->model->has('avaliacoes');

        return $this;
    }
}