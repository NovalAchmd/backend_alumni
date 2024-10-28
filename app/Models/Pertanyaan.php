<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    protected $primaryKey = 'id_pertanyaan';

    public $incrementing = true;

    protected $fillable = [
        'pertanyaan',
        'jenis',
    ];

    /**
     * Define the relationship with the DataJawaban model.
     */
    public function jawaban()
    {
        return $this->belongsTo(Data_jawaban::class, 'id_pertanyaan');
    }
}
