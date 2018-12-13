<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class GerenteGestor extends Model
{
    protected $fillable = ['id', 'nome', 'user_ad'];

    /**
     * Gestores do gerente
     *
     * @return Collection
     */
    public function gestores()
    {
        return $this->hasMany(Gestor::class);
    }
}
