<?php

namespace App\Eloquent\Repositories;

use App\Contracts\Repositories\AvaliacaoRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Eloquent\BaseEloquentRepository;
use App\Eloquent\Model;
use App\Eloquent\Models\Avaliacao;
use Carbon\Carbon;

class AvaliacaoEloquentRepository extends BaseEloquentRepository implements AvaliacaoRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Avaliacao();
    }

    /**
     * Retorna média geral NPS
     *
     * @return float
     */
    public function mediaNPS()
    {
        return $this->model()->avg('nps');
    }

    /**
     * Retorna média geral Nota Consultor
     *
     * @return float
     */
    public function mediaNotaConsultor()
    {
        return $this->model()->avg('nota_consultor');
    }

    /**
     * Retorna média geral Nota Metodologia
     *
     * @return float
     */
    public function mediaNotaMetodologia()
    {
        return $this->model()->avg('nota_metodologia');
    }

    /**
     * Retorna média geral Nota Atendimento
     *
     * @return float
     */
    public function mediaNotaAtendimento()
    {
        return $this->model()->avg('nota_atendimento');
    }

    /**
     * Retorna média geral Nota Atendimento
     *
     * @param int $meses Quantidade de meses
     * @return float
     */
    public function mediaGeralUltimosMeses($meses = 1)
    {
        $result = [];

        while($meses>0)
        {
            $mesAno = Carbon::now()->firstOfMonth()->subMonth($meses);

            $medias = $this->model()
                ->leftJoin('turmas', 'avaliacaos.turma_id', '=', 'turmas.id')
                ->whereMonth('turmas.inicio', '=', $mesAno->month)
                ->whereYear('turmas.inicio', '=', $mesAno->year)
                ->get();

            $result[$mesAno->format('m/y')] = [
                'nps' => $medias->avg('nps') ?: 0,
                'nota_consultor' => $medias->avg('nota_consultor') ?: 0,
                'nota_metodologia' => $medias->avg('nota_metodologia') ?: 0,
                'nota_atendimento' => $medias->avg('nota_atendimento') ?: 0
            ];

            $meses--;
        }

        return $result;
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return TurmaRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like) && $like!="")
        {
            $this->model = $this->model->whereHas('turma', function ($query) use ($like)
            {
                $query->where(function ($q) use ($like)
                {
                    $q->where('codigo', 'like', '%' . $like . '%');
                });
            });
        }

        return $this;
    }
}