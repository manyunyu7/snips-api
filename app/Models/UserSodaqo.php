<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSodaqo extends Model
{
    use HasFactory;


    function getMerchantAttribute(){

    }

    function getDonationAccountAttribute(){
        return DonationAccount::find($this->payment_id);
    }

    public function getPhotoPathAttribute()
    {
        if (preg_match('/^https?:\/\//', $this->photo)) {
            return $this->photo;
        }

        return asset($this->photo);
    }


    function getUserDetailAttribute(){
        $user = User::find($this->user_id);
        return $user;
    }
}
