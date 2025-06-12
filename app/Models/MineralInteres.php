<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MineralInteres extends Model {
    use HasFactory;
    protected $guarded = [];
    public function petrografia() { return $this->belongsTo(Petrografia::class); }
}
