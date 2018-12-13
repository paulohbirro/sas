<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface RegiaoRepository extends BaseRepository
{
    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return RegiaoRepository
     */
    public function whereLike($like = null);
}