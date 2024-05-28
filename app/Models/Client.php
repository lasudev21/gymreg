<?php

namespace App\Models;

use App\Orchid\Presenters\ClientPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

class Client extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected  $fillable = [
        "firstname",
        "lastname",
        "identification_type",
        "identification",
        "birthdate",
        "gender",
        "phonenumber",
        "address",
        "email",
        "dateadmission",
        "status"
    ];

    protected $allowedSorts = [
        'firstname',
        "lastname",
        "identification",
        'created_at',
        'updated_at'
    ];

    protected $allowedFilters = [
        'identification'         => Like::class,
        'lastname'       => Like::class,
        'firstname'      => Like::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];

    public function presenter(): ClientPresenter
    {
        return new ClientPresenter($this);
    }
}
