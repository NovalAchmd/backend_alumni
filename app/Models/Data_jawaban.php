<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_jawaban extends Model
{
    use HasFactory;

    protected $table = 'data_jawaban';

    protected $fillable = [
        'id_alumni',
        'id_pertanyaan',
        'jawaban_terbuka',
        'jawaban_skala',
    ];

    /**
     * Define the relationship with the Pertanyaan model.
     */
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'id_pertanyaan');
    }

    /**
     * Define the relationship with the Alumni model.
     */
    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'id_alumni');
    }
}
