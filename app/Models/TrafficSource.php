<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TrafficSource extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trafficSource) {
            if (empty($trafficSource->slug)) {
                $trafficSource->slug = Str::slug($trafficSource->name);
            }
        });

        static::updating(function ($trafficSource) {
            if ($trafficSource->isDirty('name') && empty($trafficSource->slug)) {
                $trafficSource->slug = Str::slug($trafficSource->name);
            }
        });
    }

    public function marketingExpenses(): HasMany
    {
        return $this->hasMany(MarketingExpense::class);
    }

    public function reportItems(): HasMany
    {
        return $this->hasMany(ReportItem::class);
    }
}
