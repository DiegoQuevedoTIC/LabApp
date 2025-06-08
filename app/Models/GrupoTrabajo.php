<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GrupoTrabajo extends Model
{
    use HasFactory;
    protected $guarded = [];

        public function direccionTecnica(): BelongsTo
    {
        return $this->belongsTo(DireccionTecnica::class);
    }


    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class);
    }


            public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
