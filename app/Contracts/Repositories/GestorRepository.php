<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface GestorRepository extends BaseRepository
{
    /**
     * Retorna Gestor a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD);

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return GestorRepository
     */
    public function whereLike($like = null);
}