<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\AvaliacaoRespostaRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\AvaliacaoResposta;

class AvaliacaoRespostaEloquentRepository extends BaseEloquentRepository implements AvaliacaoRespostaRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new AvaliacaoResposta();
    }

}