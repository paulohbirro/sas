<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = ['id', 'nome'];

    /**
     * Gestores da Unidade
     *
     * @return Collection
     */
    public function gestores()
    {
        return $this->hasMany(Gestor::class);
    }

    /**
     * Média NPS da Unidade
     *
     * @return float
     */
    public function nps()
    {
        return $this
            ->avaliacoes()
            ->avg('avaliacaos.nps');
    }

    /**
     * Média Nota do Consultor da Unidade
     *
     * @return float
     */
    public function notaConsultor()
    {
        return $this
            ->avaliacoes()
            ->avg('avaliacaos.nota_consultor');
    }

    /**
     * Média Nota da Metodologia da Unidade
     *
     * @return float
     */
    public function notaMetodologia()
    {
        return $this
            ->avaliacoes()
            ->avg('avaliacaos.nota_metodologia');
    }

    /**
     * Média Nota do Atendimento da Unidade
     *
     * @return float
     */
    public function notaAtendimento()
    {
        return $this
            ->avaliacoes()
            ->avg('avaliacaos.nota_atendimento');
    }

    /**
     * Soluções da Unidade
     *
     * @return Collection
     */
    public function solucoes()
    {
        return $this->hasManyThrough(Solucao::class, Gestor::class);
    }

    /**
     * Turmas da Unidade
     *
     * @return Collection
     */
    public function turmas()
    {
        return $this
            ->solucoes()
            ->leftJoin('turmas', 'solucaos.id', '=', 'turmas.solucao_id')
            ->select('turmas.*');
    }

    /**
     * Avaliações da Unidade
     *
     * @return Collection
     */
    public function avaliacoes()
    {
        return $this
            ->solucoes()
            ->leftJoin('turmas', 'solucaos.id', '=', 'turmas.solucao_id')
            ->leftJoin('avaliacaos', 'turmas.id', '=', 'avaliacaos.turma_id')
            ->select('avaliacaos.*');
    }
}
