<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Payment extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;
    protected  $fillable = [
        "amount",
        "client_id",
        "term",
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
