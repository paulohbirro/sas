<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\Collection;
use App\Contracts\Repositories\TecnicoRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Tecnico;

class TecnicoEloquentRepository extends BaseEloquentRepository implements TecnicoRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Tecnico();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return TecnicoEloquentRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
    }

    /**
     * Retorna Tecnico a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD)
    {
        return $this->model()->where('user_ad', $userAD)->get();
    }
}