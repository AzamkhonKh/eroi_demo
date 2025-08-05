<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportItem extends Model
{
    protected $fillable = [
        'report_id',
        'traffic_source_id',
        'total_amount',
        'percentage',
        'expense_count',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'percentage' => 'decimal:2',
        'expense_count' => 'integer',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(ExpenseReport::class);
    }

    public function trafficSource(): BelongsTo
    {
        return $this->belongsTo(TrafficSource::class);
    }
}
