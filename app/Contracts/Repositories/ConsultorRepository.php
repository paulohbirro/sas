<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface ConsultorRepository extends BaseRepository
{
    /**
     * Retorna consultor a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD);

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return ConsultorRepository
     */
    public function whereLike($like = null);

    /**
     * Aplica condição no repositorio para considerar apenas consultores com avaliacao
     *
     * @return ConsultorRepository
     */
    public function comAvaliacao();
}