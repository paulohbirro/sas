<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;
use Illuminate\Support\Collection;

interface MicroRegiaoRepository extends BaseRepository
{
    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return MicroRegiaoRepository
     */
    public function whereLike($like = null);

    /**
     * Aplica condição no repositório para retornar apenas microregioes com avaliações
     *
     * @param null $like
     * @return MicroRegiaoRepository
     */
    public function hasAvaliacoes();


    
}