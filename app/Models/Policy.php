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
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'premium' => 'decimal:2'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
