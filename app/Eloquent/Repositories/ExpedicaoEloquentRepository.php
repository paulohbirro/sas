<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\AdminRepository;
use App\Contracts\Repositories\ExpedicaoRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Expedicao;

class ExpedicaoEloquentRepository extends BaseEloquentRepository implements ExpedicaoRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Expedicao();
    }

    /**
     * Retorna Admin a partir de um usuario AD
     *
     * @param array $columns
     * @return mixed
     */
    public function getByUserAD($userAD)
    {
        return $this->model()->where('user_ad', $userAD)->get();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return AdminRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
    }
}