<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_prestasi extends Model
{
    protected $table = 'prestasi';
    protected $fillable = ['jenis','nama_prestasi','lokasi','tahun','tingkat'
    ,'posisi','uraian','status','foto','no_induk'];
    protected $primaryKey = 'id_prestasi';
    public $timestamps = false;

    public function User()
    {
        return $this->belongsTo('App\User','no_induk','no_induk');
    }
}
