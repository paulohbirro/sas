<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\ConsultorRepository;
use App\Contracts\Repositories\SolucaoRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Solucao;

class SolucaoEloquentRepository extends BaseEloquentRepository implements SolucaoRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Solucao();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return SolucaoRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
            $this->model = $this->model->where('nome', 'like', '%' . $like . '%');

        return $this;
    }

    /**
     * Aplica condição no repositorio para considerar apenas solucoes com avaliacao
     *
     * @return ConsultorRepository
     */
    public function comAvaliacao()
    {
        $this->model = $this->model->has('avaliacoes');

        return $this;
    }

    /**
     * Aplica condição $municipioID no repositório
     *
     * @param null $municipioID
     * @return SolucaoRepository
     */
    public function whereMunicipioId($municipioID = null)
    {
        if(!is_null($municipioID) && $municipioID > 0)
        {
            $this->model = $this->model->whereHas('turmas', function ($q) use ($municipioID)
            {
                $q->where('municipio_id', $municipioID);
            });
        }

        return $this;
    }

    /**
     * Aplica condição $microRegiaoID no repositório
     *
     * @param null $microRegiaoID
     * @return SolucaoRepository
     */
    public function whereMicroRegiaoId($microRegiaoID = null)
    {
        if(!is_null($microRegiaoID) && $microRegiaoID > 0)
        {
            $this->model = $this->model->whereHas('turmas', function ($q) use ($microRegiaoID)
            {
                $q->whereHas('municipio', function ($q) use ($microRegiaoID)
                {
                    $q->where('micro_regiao_id', $microRegiaoID);
                });
            });
        }

        return $this;
    }

    /**
     * Aplica condição $regiaoID no repositório
     *
     * @param null $regiaoID
     * @return SolucaoRepository
     */
    public function whereRegiaoId($regiaoID = null)
    {
        if(!is_null($regiaoID) && $regiaoID > 0)
        {
            $this->model = $this->model->whereHas('turmas', function ($q) use ($regiaoID)
            {
                $q->whereHas('municipio', function ($q) use ($regiaoID)
                {
                    $q->whereHas('microRegiao', function ($q) use ($regiaoID)
                    {
                        $q->where('regiao_id', $regiaoID);
                    });
                });
            });
        }

        return $this;
    }
}