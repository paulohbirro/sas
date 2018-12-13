<?php

namespace App\Eloquent\Models;

use App\Eloquent\Triggers\AvaliacaoFichaProcessadaTrigger;
use Illuminate\Database\Eloquent\Model;

class AvaliacaoFicha extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'avaliacao_id', 'image_path', 'comentario_path', 'comentario_transcrito', 'comentario_tags', 'status'];

    /**
     * Boot
     */
    public static function boot()
    {
        parent::boot();

        static::observe(new AvaliacaoFichaProcessadaTrigger());
    }

    /**
     * Belongs To Avaliação
     */
    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }

    /*
     * HasOne Comentario
     */
    public function comentario()
    {
        return $this->hasOne(AvaliacaoComentario::class);
    }

    /**
     * HasMany Respostas
     */
    public function respostas()
    {
        return $this->hasMany(AvaliacaoResposta::class);
    }

    /**
     * Verifica se possui 10 respostas
     *
     * @return boolean
     */
    public function isValido()
    {
        return $this->respostas->count() == 10;
    }

}
