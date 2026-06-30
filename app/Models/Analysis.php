<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analysis extends Model
{
    protected $table = 'analyses'; // لتجنب أي تعارض في الجمع بالإنجليزية

    protected $fillable = [
        'document_id', 
        'risk_score', 
        'critical_issues', 
        'ai_confidence', 
        'clauses_analysis'
    ];

    protected $casts = [
        'clauses_analysis' => 'array', // تحويل تلقائي من وإلى JSON
    ];

    // Analysis belongsTo Document
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}