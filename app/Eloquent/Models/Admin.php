<?php

namespace App\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['id', 'nome', 'user_ad'];
}
