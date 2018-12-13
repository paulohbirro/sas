<?php

namespace App\Contracts\Repositories;

use App\Contracts\BaseRepository;

interface SolucaoRepository extends BaseRepository
{
    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return SolucaoRepository
     */
    public function whereLike($like = null);

    /**
     * Aplica condição no repositorio para considerar apenas solucoes com avaliacao
     *
     * @return ConsultorRepository
     */
    public function comAvaliacao();

    /**
     * Aplica condição $municipioID no repositório
     *
     * @param null $municipioID
     * @return SolucaoRepository
     */
    public function whereMunicipioId($municipioID = null);

    /**
     * Aplica condição $microRegiaoID no repositório
     *
     * @param null $microRegiaoID
     * @return SolucaoRepository
     */
    public function whereMicroRegiaoId($microRegiaoID = null);

    /**
     * Aplica condição $regiaoID no repositório
     *
     * @param null $regiaoID
     * @return SolucaoRepository
     */
    public function whereRegiaoId($regiaoID = null);
}