<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $dates = ['birth'];

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

    public function setBirthAttribute($value)
    {
        $this->attributes['birth'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function clientTags(): HasMany
    {
        return $this->hasMany(ClientTag::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'client_tags', 'client_id', 'tag_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function setAddress(): string
    {
        $fullAddres = $this->address . ', ' . $this->number_address;
        $fullAddres .= ' ' . (!is_null($this->complement) ? $this->complement . ' ' : '');
        $fullAddres .= ' - ' . $this->neighborhood;
        $fullAddres .= ' - ' . $this->city->name . '/' . $this->state->abbreviation;

        return $fullAddres;
    }
}
