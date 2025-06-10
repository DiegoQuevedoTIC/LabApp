<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Muestra extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function tipoMuestra(): BelongsTo
    {
        return $this->belongsTo(TipoMuestra::class);
    }

    public function ensayos(): BelongsToMany
    {
        return $this->belongsToMany(Ensayo::class, 'ensayo_muestra');
    }

}
