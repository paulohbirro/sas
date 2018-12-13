<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class GerenteRegiao extends Model
{
    protected $fillable = ['id', 'nome', 'user_ad', 'regiao_id'];

    /**
     * Região do Gerente
     *
     * @return BelongsTo
     */
    public function regiao()
    {
        return $this->belongsTo(Regiao::class);
    }
}
