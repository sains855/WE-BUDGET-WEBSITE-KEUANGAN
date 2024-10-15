<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'kategori_id',
        'waktu',
        'Jumlah',
        'catatan',
        'image'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(kategori::class);
    }
    public function scopeincome($query){
        return $query->whereHas('kategori', function ($query){
            $query->where('keterangan', false);
        });
    }

    public function scopeoutcome($query){
        return $query->whereHas('kategori', function ($query){
            $query->where('keterangan', true);
        });
    }
}
