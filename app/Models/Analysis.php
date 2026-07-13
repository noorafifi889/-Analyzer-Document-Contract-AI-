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
                'summary',

        'critical_issues', 
        'ai_confidence', 
          'clauses_analysis' => 'array',
    'risk_distribution' => 'array', 
        'clauses_analysis'
    ];
   protected $casts = [
        'critical_issues' => 'array',
        'clauses_analysis' => 'array',
        'risk_score' => 'integer',
        'ai_confidence' => 'float',
    ];
    // Analysis belongsTo Document
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}