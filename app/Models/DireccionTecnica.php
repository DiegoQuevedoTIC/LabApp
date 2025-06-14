<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DireccionTecnica extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function gruposTrabajo(): HasMany
    {
        return $this->hasMany(GrupoTrabajo::class);
    }


}
