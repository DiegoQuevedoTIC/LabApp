<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petrografia extends Model {
    use HasFactory;

    // Permitir asignación masiva de todos los campos
    protected $guarded = [];

    // Casts para tipos de datos correctos
    protected $casts = [
        'fecha_muestreo' => 'date',
        'fecha_analisis' => 'date',
    ];

    // Relación con Minerales Opacos
    public function mineralesOpacos(): HasMany {
        return $this->hasMany(MineralDescriptivo::class)->where('tipo', 'opaco');
    }

    // Relación con Minerales Translúcidos
    public function mineralesTranslucidos(): HasMany {
        return $this->hasMany(MineralDescriptivo::class)->where('tipo', 'translucido');
    }

    // Relación con Minerales de Interés
    public function mineralesInteres(): HasMany {
        return $this->hasMany(MineralInteres::class);
    }

    // Relación con Fotografías Adicionales
    public function fotografiasAdicionales(): HasMany {
        return $this->hasMany(FotografiaAdicional::class);
    }
}
