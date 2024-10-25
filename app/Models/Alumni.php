<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;
    protected $table = 'alumni';
    protected $primaryKey = 'id_alumni';

    protected $fillable = [
        'id_user','nim', 'nama_alumni', 'angkatan', 'no_tlp', 'email', 'alamat', 'tanggal_lahir', 'foto'
    ];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(Alumni::class, 'id_user','id');
    }
}
