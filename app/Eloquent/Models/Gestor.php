<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    protected $fillable = ['id', 'nome', 'user_ad', 'gerente_gestor_id', 'unidade_id'];

    /**
     * BelongsTo GerenteGestor
     */
    public function gerenteGestor()
    {
        return $this->belongsTo(GerenteGestor::class);
    }

    /**
     * BelongsTo Unidade
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    /**
     * HasMany Solucao
     */
    public function solucoes()
    {
        return $this->hasMany(Solucao::class);
    }
}
