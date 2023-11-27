<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'zip_code',
        'address',
        'number_address',
        'complement_address',
        'neighborhood',
        'city_id',
        'state_id',
        'birth',
        'phone'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->code) {
                $lastRecord = static::orderBy('code', 'desc')->first();

                $model->code = $lastRecord ? $lastRecord->code + 1 : 1;
            }
        });
    }

    public function clientTags(): HasMany
    {
        return $this->hasMany(ClientTag::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
