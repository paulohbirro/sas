<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface TecnicoRepository extends BaseRepository
{

    /**
     * Retorna Tecnico a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD);

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return TecnicoRepository
     */
    public function whereLike($like = null);
}