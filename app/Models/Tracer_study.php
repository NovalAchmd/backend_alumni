<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracer_study extends Model
{
    use HasFactory;

    protected $table = 'tracer_study';
    
    public function Pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }
}
