<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEventMapping extends Model
{
    use HasFactory;

    protected $appends = ['user','event'];

    public function getUserAttribute(){
        return User::find($this->user_id);
    }

    public function getEventAttribute(){
        return EatEvent::find($this->event_id);
    }
}
