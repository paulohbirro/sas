<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;
use Illuminate\Support\Collection;

interface UgpRepository extends BaseRepository
{
    /**
     * Retorna UGP a partir de um usuario AD
     *
     * @param string $userAD
     * @return Collection
     */
    public function getByUserAD($userAD);

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return UgpRepository
     */
    public function whereLike($like = null);
    
}