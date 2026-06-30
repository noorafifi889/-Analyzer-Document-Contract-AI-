<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentReport extends Model
{
    protected $fillable = ['document_id', 'report_path', 'format'];

    // DocumentReport belongsTo Document
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}