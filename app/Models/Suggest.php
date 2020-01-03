<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'image',
    ];

    /**
     * Get the user that owns the suggestion.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
