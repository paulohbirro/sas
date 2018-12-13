<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\TurmaRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Turma;
use Carbon\Carbon;
use Exception;

class TurmaEloquentRepository extends BaseEloquentRepository implements TurmaRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Turma();
    }

    /**
     * Aplica condição $status no repositório
     *
     * @param null $like
     * @return TurmaRepository
     */
    public function whereStatus($status = null)
    {
        if(is_array($status))
        {
            $this->model = $this->model->where(function($q) use ($status)
            {
                foreach($status as $i)
                    $q->orWhere('status', '=', $i);
            });
        }else
            $this->model = $this->model->where(['status' => $status]);

        return $this;
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return TurmaRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="") {
            $this->model = $this->model->where(function ($q) use ($like) {

                $q->where('codigo', 'like', '%' . $like . '%')
                    ->orWhere(function ($q) use ($like) {
                        $q->whereHas('solucao', function ($query) use ($like) {
                            $query->where(function ($query) use ($like) {
                                $query->where('nome', 'like', '%' . $like . '%');
                            });
                        });
                    })
                    ->orWhere(function ($q) use ($like) {
                        $q->whereHas('municipio', function ($query) use ($like) {
                            $query->where(function ($query) use ($like) {
                                $query->where('nome', 'like', '%' . $like . '%');
                            });
                        });
                    });
            });
        }

        return $this;
    }

    /**
     * Aplica condição $de - $ate na data de inicio
     *
     * @param null $de
     * @param null $ate
     * @return TurmaRepository
     */
    public function periodo($de = null, $ate = null)
    {
        try{
            $de = Carbon::createFromFormat('d/m/Y', $de);
        }catch (Exception $e){
            $de = null;
        }

        try{
            $ate = Carbon::createFromFormat('d/m/Y', $ate);
        }catch (Exception $e){
            $ate = null;
        }

        if(!is_null($de))
            $this->model = $this->model->where('inicio', '>=', $de);


        if(!is_null($ate))
            $this->model = $this->model->where('inicio', '<=', $ate);

        return $this;
    }

    /**
     * Aplica condição $dias anteriores a data atual na data de inicio
     *
     * @param null $dias
     * @return TurmaRepository
     */
    public function ultimosDias($dias = null)
    {
        if(!is_null($dias))
        {
            $de = Carbon::now()->subDays($dias);
            $ate = Carbon::now();

            $this->model = $this->model->whereBetween('inicio', [$de, $ate]);
        }
    }

    /**
     * Retorna uma turma pelo código
     *
     * @param string $codigo
     * @return mixed
     */
    public function getByCodigo($codigo)
    {
        return $this->model()->where('codigo', $codigo)->first();
    }

    /**
     * Aplica condição $microRegiaoID no repositório
     *
     * @param null $microRegiaoID
     * @return TurmaRepository
     */
    public function whereMicroRegiaoId($microRegiaoID = null)
    {
        if(!is_null($microRegiaoID) && $microRegiaoID > 0) {
            $this->model = $this->model->whereHas('municipio', function ($q) use ($microRegiaoID)
            {
                $q->where('micro_regiao_id', $microRegiaoID);
            });
        }

        return $this;
    }

    /**
     * Aplica condição $regiaoID no repositório
     *
     * @param null $regiaoID
     * @return TurmaRepository
     */
    public function whereRegiaoId($regiaoID = null)
    {
        if(!is_null($regiaoID) && $regiaoID > 0) {
            $this->model = $this->model->whereHas('municipio', function ($q) use ($regiaoID)
            {
                $q->whereHas('microRegiao', function ($q) use ($regiaoID)
                {
                    $q->where('regiao_id', $regiaoID);
                });
            });
        }

        return $this;
    }
}