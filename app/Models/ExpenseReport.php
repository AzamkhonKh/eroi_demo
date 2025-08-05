<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseReport extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'filters',
        'summary_data',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'filters' => 'array',
        'summary_data' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reportItems(): HasMany
    {
        return $this->hasMany(ReportItem::class);
    }
}
