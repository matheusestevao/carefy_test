<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'name',
        'birth',
        'phone'
    ];

    public function clientTags(): HasMany
    {
        return $this->hasMany(ClientTag::class);
    }
}
