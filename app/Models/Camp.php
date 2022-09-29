<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Camp extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id', 'slug',
    ];

    protected function getIsRegisteredAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return Order::whereCampId($this->id)->whereUserId(Auth::id())->exists();
    }
}
