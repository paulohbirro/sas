<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface ExpedicaoRepository extends BaseRepository
{
    /**
     * Retorna Admin a partir de um usuario AD
     *
     * @param array $columns
     * @return mixed
     */
    public function getByUserAD($userAD);

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return AdminRepository
     */
    public function whereLike($like = null);

}