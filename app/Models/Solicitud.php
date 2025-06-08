<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Solicitud extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class);
    }


    public function direccionTecnica(): BelongsTo
    {
        return $this->belongsTo(DireccionTecnica::class);
    }


    public function grupoTrabajo(): BelongsTo
    {
        return $this->belongsTo(GrupoTrabajo::class);
    }


    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }


    public function ensayos(): BelongsToMany
    {
        return $this->belongsToMany(Ensayo::class, 'ensayo_solicitud');
    }



}
