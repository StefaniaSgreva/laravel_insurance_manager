<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'policy_number',
        'type',
        'premium',
        'coverage_amount',
        'start_date',
        'end_date',
        'status',
        'details',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'premium' => 'decimal:2',
        'coverage_amount' => 'decimal:2',
        'details' => 'array',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
