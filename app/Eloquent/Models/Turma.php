<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class Turma extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'codigo', 'inicio', 'fim', 'vagas', 'participantes', 'local_execucao', 'endereco_execucao', 'status', 'descricao', 'consultor_id', 'solucao_id', 'municipio_id'];

    protected $dates = ['inicio', 'fim'];

    public function avaliacao(){
        return $this->hasOne(Avaliacao::class);
    }

    public function consultor(){
        return $this->belongsTo(Consultor::class);
    }

    public function solucao(){
        return $this->belongsTo(Solucao::class);
    }

    public function municipio(){
        return $this->belongsTo(Municipio::class);
    }
}
