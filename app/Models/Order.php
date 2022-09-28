<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function date(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => DateTime::createFromFormat('Y-n', $value)->format('Y-m-d'),
        );

        // return new Attribute(
        //     fn ($value) => Date('Y-m-d', time()),
        //     fn ($value) => Date('Y-m-d', time()),
        // );
    }

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }
}
