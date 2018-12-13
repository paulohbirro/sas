<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface GerenteRegiaoRepository extends BaseRepository
{

    /**
     * Retorna GerenterRegiao a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD);

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return GerenteRegiaoRepository
     */
    public function whereLike($like = null);
}