<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $primaryKey = 'id_perusahaan';

    protected $fillable =  ['id_perusahaan', 'id_user' , 'nama_perusahaan', 'nib', 'alamat', 'email', 'sektor_bisnis'
    , 'deskripsi_perusahaan', 'jumlah_karyawan', 'no_tlp', 'foto', 'website_perusahaan', 'status'];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(Alumni::class, 'id_user','id');
    }
}
