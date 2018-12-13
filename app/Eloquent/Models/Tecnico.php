<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tecnico extends Model
{
    protected $fillable = ['id', 'nome', 'user_ad', 'micro_regiao_id'];

    /**
     * MicroRegião do Tecnico
     *
     * @return BelongsTo
     */
    public function microRegiao()
    {
        return $this->belongsTo(MicroRegiao::class);
    }

}
