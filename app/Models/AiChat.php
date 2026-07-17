<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiChat extends Model
{
    protected  $fillable = [
    'document_id',
    'user_id',
    'message',
    'response',
    'source_quote'
];

    // AiChat belongsTo Document
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    // AiChat belongsTo User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}