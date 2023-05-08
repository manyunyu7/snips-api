<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KTPIdentification extends Model
{
    protected $appends = ['user_detail', 'photo_ktp_full_path'];
    use HasFactory;

    protected $table = "ktp";

    function getUserDetailAttribute()
    {
        return "";
    }

    function getPhotoKtpFullPathAttribute()
    {
        if ($this->photo_stored != null)
            return asset($this->photo_stored);
        else
            return asset($this->photo_requested);
    }

}
