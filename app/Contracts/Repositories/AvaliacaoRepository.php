<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface AvaliacaoRepository extends BaseRepository
{
    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return TurmaRepository
     */
    public function whereLike($like = null);

    /**
     * Retorna média geral NPS
     *
     * @return float
     */
    public function mediaNPS();

    /**
     * Retorna média geral Nota Consultor
     *
     * @return float
     */
    public function mediaNotaConsultor();

    /**
     * Retorna média geral Nota Metodologia
     *
     * @return float
     */
    public function mediaNotaMetodologia();

    /**
     * Retorna média geral Nota Atendimento
     *
     * @return float
     */
    public function mediaNotaAtendimento();

    /**
     * Retorna média geral Nota Atendimento
     *
     * @param int $meses Quantidade de meses
     * @return float
     */
    public function mediaGeralUltimosMeses($meses = 1);


}