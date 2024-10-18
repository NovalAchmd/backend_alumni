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
        'user_id','nim', 'nama_alumni', 'angkatan', 'no_tlp', 'email'
    ];

    public function Alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
