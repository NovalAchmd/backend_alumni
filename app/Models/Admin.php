<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'admins';

    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'id_user', 'nama', 'nomor_induk',
    ];

    public function user()
    {
        return $this->belongsTo(Alumni::class, 'id_user','id');
    }
}
