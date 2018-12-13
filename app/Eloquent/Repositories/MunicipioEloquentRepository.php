<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\MunicipioRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Municipio;

class MunicipioEloquentRepository extends BaseEloquentRepository implements MunicipioRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Municipio();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return MunicipioEloquentRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
    }

    /**
     * Aplica condição $regiaoID no repositório
     *
     * @param null $regiaoID
     * @return MunicipioRepository
     */
    public function whereRegiaoId($regiaoID = null)
    {
        if(!is_null($regiaoID) && $regiaoID > 0) {
            $this->model = $this->model->whereHas('microRegiao', function ($q) use ($regiaoID)
            {
                $q->where('regiao_id', $regiaoID);
            });
        }

        return $this;
    }
}