<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    protected $primaryKey = 'id_pertanyaan';

    protected $fillable = ['pertanyaan', 'jenis'];

    public function Pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni', 'id_alumni');
    }
}
