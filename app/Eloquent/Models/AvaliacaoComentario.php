<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoComentario extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'avaliacao_id', 'avaliacao_ficha_id', 'comentario_path', 'comentario_transcrito', 'comentario_tags'];

    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * Belongs To Avaliação
     */
    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }

    /**
     * Belongs To Ficha
     */
    public function ficha()
    {
        return $this->belongsTo(AvaliacaoFicha::class);
    }
}
