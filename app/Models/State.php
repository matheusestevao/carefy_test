<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;
    use HasUuids;
    
    public $timestamps = false;

    protected $fillable = [
        'number',
        'name',
        'abbreviation'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
