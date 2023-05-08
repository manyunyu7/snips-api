<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komplain extends Model
{
    use HasFactory;

    protected $appends = ["name", "nik", "contact"];

    function getNameAttribute()
    {
        $user = KTPIdentification::where("user_id", '=', $this->user_id)->first();
        if ($user != null) {
            return $user->name;
        } else {
            return "";
        }
    }

    function getNikAttribute()
    {
        $user = KTPIdentification::where("user_id", '=', $this->user_id)->first();
        if ($user != null) {
            return $user->nik;
        } else {
            return "";
        }
    }

    function getContactAttribute()
    {
        $user = User::where("id", '=', $this->user_id)->first();
        if ($user != null) {
            return $user->contact;
        } else {
            return "";
        }
    }

}
