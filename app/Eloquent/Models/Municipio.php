<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $fillable = ['id', 'nome', 'micro_regiao_id'];

    /**
     * Média NPS do Município
     *
     * @return float
     */
    public function nps()
    {
        return $this
            ->turmas()
            ->leftJoin('avaliacaos', 'turmas.id', '=', 'avaliacaos.turma_id')
            ->avg('avaliacaos.nps');
    }

    /**
     * MicroRegião do Município
     *
     * @return MicroRegiao
     */
    public function microRegiao()
    {
        return $this->belongsTo(MicroRegiao::class);
    }

    /**
     * Turmas do Municipio
     *
     * @return Collection
     */
    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    /**
     * Avaliações do Município
     *
     * @return Collection
     */
    public function avaliacoes()
    {
        return $this->hasManyThrough(Avaliacao::class, Turma::class);
    }
}
