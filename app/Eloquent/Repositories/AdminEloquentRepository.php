<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\AdminRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Admin;

class AdminEloquentRepository extends BaseEloquentRepository implements AdminRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Admin();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return AdminEloquentRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
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
}