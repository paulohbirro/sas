<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoResposta extends Model
{
    protected $fillable = ['id', 'avaliacao_ficha_id', 'avaliacao_pergunta_id', 'resposta', 'manual'];

    protected $casts = [
        'id' => 'integer',
        'avaliacao_ficha_id' => 'integer',
        'avaliacao_pergunta_id' => 'integer'
    ];

    /*
     * Belongs To Ficha
     */
    public function ficha()
    {
        return $this->belongsTo(AvaliacaoFicha::class);
    }

    /*
     * Belongs To Pergunra
     */
    public function pergunta()
    {
        return $this->belongsTo(AvaliacaoPergunta::class);
    }
}
