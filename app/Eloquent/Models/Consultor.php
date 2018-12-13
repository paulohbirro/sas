<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Consultor extends Model
{
    protected $fillable = ['id', 'nome', 'cpf', 'user_ad', 'tipo', 'senha', 'email', 'chave_recuperacao'];

    /**
     * Média NPS do Consultor
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
     * Média Nota do Consultor
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
     * Média Dominio do Consultor
     *
     * @return float
     */
    public function mediaDominio()
    {
        return $this
            ->avaliacoes()
            ->avg('avaliacaos.nota_consultor_dominio');
    }

    /**
     * Média Clareza do Consultor
     *
     * @return float
     */
    public function mediaClareza()
    {
        return $this
            ->avaliacoes()
            ->avg('avaliacaos.nota_consultor_clareza');
    }

    /**
     * Média Recursos do Consultor
     *
     * @return float
     */
    public function mediaRecursos()
    {
        return $this
            ->avaliacoes()
            ->avg('avaliacaos.nota_consultor_recursos');
    }

    /**
     * Média Exemplos do Consultor
     *
     * @return float
     */
    public function mediaExemplos()
    {
        return $this
            ->avaliacoes()
            ->avg('avaliacaos.nota_consultor_exemplos');
    }

    /**
     * Turmas do Consultor
     *
     * @return Collection
     */
    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    /**
     * Avaliações do Consultor
     *
     * @return Collection
     */
    public function avaliacoes()
    {
        return $this->hasManyThrough(Avaliacao::class, Turma::class);
    }

    /**
     * Soluções ministradas pelo consultor
     *
     * @return Collection
     */
    public function solucoes()
    {
        return $this
            ->avaliacoes()
            ->leftJoin('solucaos', 'solucaos.id', '=', 'turmas.solucao_id')
            ->selectRaw('solucaos.id, solucaos.nome, avg(avaliacaos.nota_consultor) as media')
            ->groupBy('solucaos.id', 'solucaos.nome')
            ->orderBy('solucaos.nome', 'ASC')
            ->get();
    }
}
