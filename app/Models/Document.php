<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    protected $fillable = ['user_id', 'original_name', 'title', 'file_path', 'status'];

    // Document belongsTo User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Document hasMany Analysis
    public function analyses(): HasMany
    {
        return $this->hasMany(Analysis::class);
    }

    // Document hasMany AiChats
    public function aiChats(): HasMany
    {
        return $this->hasMany(AiChat::class);
    }

    // Document hasOne DocumentReport
    public function report(): HasOne
    {
        return $this->hasOne(DocumentReport::class);
    }
}