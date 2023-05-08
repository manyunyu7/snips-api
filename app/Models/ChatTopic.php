<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatTopic extends Model
{
    use HasFactory;
    protected $appends = ['user','last_message'];

    function getUserAttribute(){
        return User::find($this->belongs_to);
    }

    function getLastMessageAttribute(){
        $data = CsChat::where("topic_id",'=',$this->id)->orderBy('id','DESC')->first();
        return$data;
    }
}
