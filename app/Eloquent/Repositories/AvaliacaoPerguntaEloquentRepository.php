<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\AvaliacaoPerguntaRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\AvaliacaoPergunta;

class AvaliacaoPerguntaEloquentRepository extends BaseEloquentRepository implements AvaliacaoPerguntaRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new AvaliacaoPergunta();
    }

}