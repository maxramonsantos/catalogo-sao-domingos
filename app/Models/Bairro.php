<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bairro extends Model
{
    protected $fillable = ['nome', 'slug'];

    public function comercios(): HasMany
    {
        return $this->hasMany(Comercio::class);
    }
}
