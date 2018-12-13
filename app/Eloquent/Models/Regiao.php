<?php

namespace App\Eloquent\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Regiao extends Model
{
    protected $fillable = ['id', 'nome'];

    /**
     * Média NPS da Região
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
     * Média Nota do Consultor da Região
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
     * Média Nota da Metodologia da Região
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
     * Média Nota do Atendimento da Região
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
     * Microregioes da Região
     *
     * @return Collection
     */
    public function microregioes()
    {
        return $this->hasMany(MicroRegiao::class);
    }

    /**
     * Gerentes da Região
     *
     * @return Collection
     */
    public function gerentes()
    {
        return $this->hasMany(GerenteRegiao::class);
    }

    /**
     * Municípios da Região
     *
     * @return Collection
     */
    public function municipios()
    {
        return $this->hasManyThrough(Municipio::class, MicroRegiao::class);
    }

    /**
     * Turmas da Região
     *
     * @return Collection
     */
    public function turmas()
    {
        return $this
            ->municipios()
            ->leftJoin('turmas', 'municipios.id', '=', 'turmas.municipio_id')
            ->select('turmas.*');
    }

    /**
     * Avaliações da Região
     *
     * @return Collection
     */
    public function avaliacoes()
    {
        return $this
            ->municipios()
            ->leftJoin('turmas', 'municipios.id', '=', 'turmas.municipio_id')
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
