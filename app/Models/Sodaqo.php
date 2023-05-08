<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sodaqo extends Model
{
    use HasFactory;

    protected $appends = ['photo_path', 'creator', "isHaveTarget",
        "fundraising_target_formatted","category_name","accumulated_amount"];

    public function scopeIsNotDeleted($query)
    {
        return $query->whereNull('is_deleted');
    }

    function getPhotoPathAttribute()
    {
        return asset($this->photo);
    }

    function getCreatorAttribute()
    {
        $user = User::find($this->owner_id);
        return $user;
    }

    function getCategoryNameAttribute()
    {
        $cat = SodaqoCategory::find($this->id);
        if ($cat!=null){
            return $cat->name;
        }
        return "";
    }


    function getFundraisingTargetFormattedAttribute()
    {
        return number_format($this->fundraising_target, 0, ".", ",");
    }

    function getAccumulatedAmountAttribute()
    {
        // Set the batch size
        $batchSize = 1000;

        // Initialize the accumulated amount
        $accumulatedAmount = 0;

        // Initialize the offset
        $offset = 0;

        // Loop until all rows have been processed
//        while (true) {
//            // Retrieve the nominal_net values in batches
//            $data = DB::select("SELECT nominal_net FROM user_sodaqos WHERE sodaqo_id = ? AND status = 1 LIMIT ?, ?", [$this->id, $offset, $batchSize]);
//
//            // Break the loop if no rows were returned
//            if (empty($data)) {
//                break;
//            }
//
//            // Increment the offset
//            $offset += $batchSize;
//
//            // Add the nominal_net values to the accumulated amount
//            foreach ($data as $item) {
//                $accumulatedAmount += $item->nominal_net;
//            }
//        }

        // Return the accumulated amount
        return $accumulatedAmount;
    }

    function getIsHaveTargetAttribute()
    {
        $isHaveTarget = false;
        if (isset($this->fundraising_target) && !empty($this->fundraising_target)) {
            $isHaveTarget = true;
        }
        return $isHaveTarget;
    }


}
