<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoPergunta extends Model
{
    protected $fillable = ['id', 'numero', 'pergunta', 'opcoes'];

    protected $casts = [
        'id' => 'integer'
    ];
}
