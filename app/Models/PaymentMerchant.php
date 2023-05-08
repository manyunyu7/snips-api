<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMerchant extends Model
{
    use HasFactory;

    protected $appends = ['photo_path'];

    protected static function boot()
    {
        parent::boot();

//        static::addGlobalScope('is_deleted', function ($builder) {
//            $builder->whereNull('is_deleted');
//        });
    }

    public function scopeIsNotDeleted($query)
    {
        return $query->whereNull('is_deleted');
    }

    function getPhotoPathAttribute()
    {
        return asset($this->photo);
    }

}
