<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User_progress extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Levels::class, 'id_level');
    } // belongsTo()

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
