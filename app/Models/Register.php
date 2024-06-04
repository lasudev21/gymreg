<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Register extends Model
{
    use Chartable, HasFactory, AsSource, Filterable, Attachable;
    protected  $fillable = [
        "income",
        "client_id",
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
