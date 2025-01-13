<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori_id',
        'waktu',
        'user_id',
        'Jumlah',
        'catatan',
        'nama orang',
        'image',
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

    public static function query(): Builder
    {
        return parent::query()->where('user_id', auth()->id());
    }
}
