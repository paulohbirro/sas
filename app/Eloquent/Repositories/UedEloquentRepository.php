<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\UedRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Ued;

class UedEloquentRepository extends BaseEloquentRepository implements UedRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Ued();
    }

    /**
     * Retorna UED a partir de um usuario AD
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
     * @return UedRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
    }
}