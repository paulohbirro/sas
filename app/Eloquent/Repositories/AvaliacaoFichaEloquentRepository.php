<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\AvaliacaoFichaRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\AvaliacaoFicha;

class AvaliacaoFichaEloquentRepository extends BaseEloquentRepository implements AvaliacaoFichaRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new AvaliacaoFicha();
    }

}