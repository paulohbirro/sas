<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface MunicipioRepository extends BaseRepository
{

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return MunicipioRepository
     */
    public function whereLike($like = null);

    /**
     * Aplica condição $regiaoID no repositório
     *
     * @param null $regiaoID
     * @return MunicipioRepository
     */
    public function whereRegiaoId($regiaoID = null);

}