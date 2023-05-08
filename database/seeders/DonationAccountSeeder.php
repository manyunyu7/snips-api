<?php

namespace Database\Seeders;

use App\Models\DonationAccount;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->store("Henry Augusta","088223738709","",1,"1","");
        $this->store("Henry Augusta","5680630846","",1,"2","");
        $this->store("Henry Augusta","088223738709","",1,"3","");
        $this->store("Henry Augusta","088223738709","",1,"4","");
        $this->store("Henry Augusta","3414109051","",1,"5","");
    }

    public function store($name,$accountNumber, $desc, $status,$merch_id,$photoPath)
    {
        $data = new DonationAccount();
        $data->name = $name;
        $data->account_number = $accountNumber;
        $data->m_description = $desc;
        $data->status = $status;
        $data->created_by = 1;
        $data->payment_merchant_id = $merch_id;
        $data->photo = "";
        $data->save();
    }
}
