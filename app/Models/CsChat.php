<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsChat extends Model
{
    protected $appends = ["photo_path","user"];
    use HasFactory;

    function getUserAttribute(){
        return User::find($this->sender_id);
    }

    function getPhotoPathAttribute(){
        return asset($this->photo);
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d h:i:s'
    ];
}
