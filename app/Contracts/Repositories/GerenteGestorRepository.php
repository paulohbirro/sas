<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface GerenteGestorRepository extends BaseRepository
{
    /**
     * Retorna gerenteGestor a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD);

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return GerenteGestorRepository
     */
    public function whereLike($like = null);
}