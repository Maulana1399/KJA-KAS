<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'categories_id',
        'date_transactions',
        'amount',
        'note',
        "image"
    ];

    public function categories(): BelongsTo
    {
        return $this->belongsTo(categories::class);
    }

    public function scopeExpenses($query)
    {
        return $query->whereHas('categories', function($query) {
            $query->where('is_expense', true);
        });
    }
    public function scopeIncomes($query)
    {
        return $query->whereHas('categories', function($query) {
            $query->where('is_expense', false);
        });
    }
}
