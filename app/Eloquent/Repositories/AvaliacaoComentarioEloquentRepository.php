<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\AvaliacaoComentario;

class AvaliacaoComentarioEloquentRepository extends BaseEloquentRepository implements AvaliacaoComentarioRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new AvaliacaoComentario();
    }

}