<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanAdopsi extends Model
{
    protected $table = 'pengajuan_adopsi';

    protected $fillable = [
        'user_id',
        'pet_id',
        'alasan_adopsi',
        'status',
        'alasan_penolakan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}