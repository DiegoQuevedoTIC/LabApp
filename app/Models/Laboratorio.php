<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laboratorio extends Model
{
    use HasFactory;
    protected $guarded = [];


            public function rol(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

}
