<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\UgpRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Ugp;

class UgpEloquentRepository extends BaseEloquentRepository implements UgpRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Ugp();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return UgpRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
    }

    /**
     * Retorna UGP a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD)
    {
        return $this->model()->where('user_ad', $userAD)->get();
    }
}