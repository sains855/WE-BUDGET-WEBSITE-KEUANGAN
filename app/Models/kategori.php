<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'user_id',
        'keterangan',
        'image'
    ];

    public static function query(): Builder
    {
        return parent::query()->where('user_id', auth()->id());
    }
}
