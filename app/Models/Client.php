<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'fiscal_code'];

    public function policies(): HasMany
    {
        return $this->hasMany(Policy::class);
    }
}
