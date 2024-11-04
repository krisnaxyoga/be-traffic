<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Questions extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Levels::class, 'id_level');
    } // belongsTo()

    public function sign(): BelongsTo
    {
        return $this->belongsTo(Traffic_sign::class, 'id_sign');
    } // belongsTo()
}
