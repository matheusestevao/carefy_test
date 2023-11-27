<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientTag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'client_id',
        'tag_id',
    ];

    public function tags(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function clients(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
