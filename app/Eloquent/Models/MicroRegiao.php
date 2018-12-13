<?php

namespace App\Eloquent\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MicroRegiao extends Model
{
    protected $fillable = ['id', 'nome', 'regiao_id'];

    /**
     * Média NPS da MicroRegião
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
     * Média Nota do Consultor da MicroRegião
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
     * Média Nota da Metodologia da MicroRegião
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
     * Média Nota do Atendimento da MicroRegião
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
     * Região da MicroRegião
     *
     * @return Regiao
     */
    public function regiao()
    {
        return $this->belongsTo(Regiao::class);
    }

    /**
     * Municipios da MicroRegião
     *
     * @return Collection
     */
    public function municipios()
    {
        return $this->hasMany(Municipio::class);
    }

    /**
     * Tecnicos da MicroRegião
     *
     * @return Collection
     */
    public function tecnicos()
    {
        return $this->hasMany(Tecnico::class);
    }

    /**
     * Turmas da MicroRegião
     *
     * @return Collection
     */
    public function turmas()
    {
        return $this->hasManyThrough(Turma::class, Municipio::class);
    }

    /**
     * Avaliações da MicroRegião
     *
     * @return Collection
     */
    public function avaliacoes()
    {
        return $this
            ->turmas()
            ->leftJoin('avaliacaos', 'turmas.id', '=', 'avaliacaos.turma_id')
            ->select('avaliacaos.*');
    }

    /**
     * Média de determinado parametro por mes
     *
     * @return Collection
     */
    public function mediaPorMes(Carbon $mesAno, $parametro)
    {
        $result = $this
            ->avaliacoes()
            ->whereMonth('inicio', '=', $mesAno->month)
            ->whereYear('inicio', '=', $mesAno->year)
            ->avg($parametro);

        return $result ?: 0;
    }
}
