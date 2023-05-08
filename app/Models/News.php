<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $appends = ['photo_path', 'date_indo', 'type_desc'];

    function getPhotoPathAttribute()
    {
        return asset($this->photo);
    }

    function getTypeDescAttribute()
    {
        $retVal = "";
        switch ($this->type) {
            case 1:
                $retVal = "Berita";
                break;
            case 2:
                $retVal = "Kajian";
                break;
            case 3:
                $retVal = "Informasi Event";
                break;
            case 4:
                $retVal = "Tentang Aplikasi";
                break;
            case 5:
                $retVal = "Quran/Hadits";
                break;
            case 6:
                $retVal = "Lainnya";
                break;
        }
        return $retVal;
    }

    function getDateIndoAttribute()
    {
        $dbDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)
            ->locale('id')->isoFormat('dddd, D MMMM Y');
        return $dbDate;
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
    ];

}
