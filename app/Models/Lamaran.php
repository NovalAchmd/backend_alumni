<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamaran';
    protected $guarded = [];
    protected $primaryKey = 'id_lamaran';

    protected $fillable = ['id_lamaran', 'id_alumni', 'id_lowongan', 'nama_pelamar', 'email', 'CV', 'transkrip_nilai', 'sertifikat',
    'portopolio', 'status'];
}
