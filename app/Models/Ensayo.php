<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ensayo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function laboratorio(): BelongsTo
    {
        return $this->belongsTo(Laboratorio::class);
    }


        public function claseEnsayo(): BelongsTo
    {
        return $this->belongsTo(ClaseEnsayo::class);
    }

    public function muestras(): BelongsToMany
    {
        return $this->belongsToMany(Muestra::class, 'ensayo_muestra');
    }
}
