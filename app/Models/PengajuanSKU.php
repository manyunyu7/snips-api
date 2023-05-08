<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSKU extends Model
{
    protected $appends = ['ktp_data','event_data'];
    use HasFactory;

    public function getKtpDataAttribute()
    {
        return  KTPIdentification::where("user_id", '=', $this->user_id)->first();
    }

    public function getEventDataAttribute()
    {
        $data = BansosEvent::where("id", '=', $this->event_id)->first();
        return $data;
    }
}
