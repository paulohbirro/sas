<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface TurmaRepository extends BaseRepository
{
    /**
     * Aplica condição $status no repositório
     *
     * @param null $like
     * @return TurmaRepository
     */
    public function whereStatus($status = null);

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return TurmaRepository
     */
    public function whereLike($like = null);

    /**
     * Aplica condição $microRegiaoID no repositório
     *
     * @param null $microRegiaoID
     * @return TurmaRepository
     */
    public function whereMicroRegiaoId($microRegiaoID = null);

    /**
     * Aplica condição $regiaoID no repositório
     *
     * @param null $regiaoID
     * @return TurmaRepository
     */
    public function whereRegiaoId($regiaoID = null);


    /**
     * Aplica condição $de - $ate na data de inicio
     *
     * @param null $de
     * @param null $ate
     * @return TurmaRepository
     */
    public function periodo($de = null, $ate = null);

    /**
     * Aplica condição $dias anteriores a data atual na data de inicio
     *
     * @param null $dias
     * @return TurmaRepository
     */
    public function ultimosDias($dias = null);

    /**
     * Retorna uma turma pelo código
     *
     * @param string $codigo
     * @return mixed
     */
    public function getByCodigo($codigo);
}