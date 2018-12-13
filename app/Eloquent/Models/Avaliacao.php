<?php

namespace App\Eloquent\Models;

use App\Eloquent\Triggers\AvaliacaoProcessadaTrigger;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{

    protected $fillable = [
        'id', 'turma_id', 'quantidade', 'digitalizado', 'detratores', 'passivos', 'promotores',
        'nps_meta', 'nota_consultor_meta', 'nota_metodologia_meta', 'nota_atendimento_meta',
        'nps', 'nota_consultor', 'nota_consultor_dominio', 'nota_consultor_clareza', 'nota_consultor_recursos', 'nota_consultor_exemplos',
        'nota_metodologia', 'nota_metodologia_duracao', 'nota_metodologia_material',
        'nota_atendimento', 'nota_atendimento_prestado', 'nota_atendimento_ambiente',
        'status', 'erro'
    ];

    /**
     * Boot
     */
    public static function boot()
    {
        parent::boot();

        static::observe(new AvaliacaoProcessadaTrigger);
    }

    /*
     * Belongs To Turma
     */
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    /*
     * HasMany Comentarios
     */
    public function comentarios()
    {
        return $this->hasMany(AvaliacaoComentario::class);
    }

    /*
     * HasMany Fichas
     */
    public function fichas()
    {
        return $this->hasMany(AvaliacaoFicha::class);
    }

    /*
     * HasMany Comentários sem ficha
     */
    public function comentariosSemFicha()
    {
        return $this->hasMany(AvaliacaoComentario::class);
    }

    /*
     * HasManyThrough Respostas
     */
    public function respostas()
    {
        return $this->hasManyThrough(AvaliacaoResposta::class, AvaliacaoFicha::class);
    }

    /**
     * Retorna quantidade de fichas com questoes não reconhecidas
     *
     * @return int
     */
    public function fichasComErro()
    {
        $erros = 0;

        foreach($this->fichas as $ficha)
        {
            if(!$ficha->isValido())
                $erros++;
        }

        return $erros;
    }

}
