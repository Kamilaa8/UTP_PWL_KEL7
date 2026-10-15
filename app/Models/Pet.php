<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species',
        'breed',
        'age',
        'gender',
        'photo',
        'status',
        'description',
    ];

    public function pengajuanAdopsi()
    {
        return $this->hasMany(PengajuanAdopsi::class);
    }
}
