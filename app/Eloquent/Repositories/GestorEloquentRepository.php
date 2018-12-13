<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\Collection;
use App\Contracts\Repositories\GestorRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Gestor;

class GestorEloquentRepository extends BaseEloquentRepository implements GestorRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Gestor();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return GestorRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
    }

    /**
     * Retorna Gestor a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD)
    {
        return $this->model()->where('user_ad', $userAD)->get();
    }
}