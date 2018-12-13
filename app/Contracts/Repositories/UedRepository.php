<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface UedRepository extends BaseRepository
{
    /**
     * Retorna UED a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD);

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return UedRepository
     */
    public function whereLike($like = null);

}