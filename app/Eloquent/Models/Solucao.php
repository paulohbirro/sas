<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Solucao extends Model
{
    protected $fillable = ['id', 'nome', 'gestor_id'];

    /**
     * BelongsTo Gestor
     *
     * @return float
     */
    public function gestor()
    {
        return $this->belongsTo(Gestor::class);
    }

    /**
     * Média NPS da Solução
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
     * Média Nota do Consultor da Solucao
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
     * Média Nota da Metodologia da Solucao
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
     * Média Nota do Atendimento da Solucao
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
     * Turmas da Solução
     *
     * @return Collection
     */
    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    /**
     * Avaliações da Solução
     *
     * @return Collection
     */
    public function avaliacoes()
    {
        return $this->hasManyThrough(Avaliacao::class, Turma::class);
    }

    /**
     * Media da solução por microregiao
     *
     * @return Collection
     */
    public function indicadoresPorMicroRegiao()
    {
        $result = [];

        foreach($this
            ->avaliacoes()
            ->leftJoin('municipios', 'municipios.id', '=', 'turmas.municipio_id')
            ->leftJoin('micro_regiaos', 'micro_regiaos.id', '=', 'municipios.micro_regiao_id')
            ->leftJoin('regiaos', 'regiaos.id', '=', 'micro_regiaos.regiao_id')
            ->selectRaw('micro_regiaos.nome as microrregiao,'.
                'micro_regiaos.id as id_microrregiao,'.
                'regiaos.nome as regiao,'.
                'regiaos.id as id_regiao,'.
                'avg(avaliacaos.nps) as nps,'.
                'avg(avaliacaos.nota_consultor) as nota_consultor,'.
                'avg(avaliacaos.nota_metodologia) as nota_metodologia,'.
                'avg(avaliacaos.nota_atendimento) as nota_atendimento')
            ->groupBy('micro_regiaos.id', 'regiaos.id')
            ->get() as $row)
        {
            $row['nps'] = number_format($row['nps'], 1, '.', '');
            $row['nota_consultor'] = number_format($row['nota_consultor'], 1, '.', '');
            $row['nota_metodologia'] = number_format($row['nota_metodologia'], 1, '.', '');
            $row['nota_atendimento'] = number_format($row['nota_atendimento'], 1, '.', '');

            $result[$row['regiao']][] = [
                'microrregiao' => $row->microrregiao,
                'id_microrregiao' => $row->id_microrregiao,
                'regiao' => $row->regiao,
                'id_regiao' => $row->id_regiao,
                'nps' => $row->nps,
                'nota_consultor' => $row->nota_consultor,
                'nota_metodologia' => $row->nota_metodologia,
                'nota_atendimento' => $row->nota_atendimento,
            ];
        }

        return $result;
    }
}
