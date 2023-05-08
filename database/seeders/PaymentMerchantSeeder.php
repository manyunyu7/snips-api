<?php

namespace Database\Seeders;

use App\Models\DonationAccount;
use App\Models\PaymentMerchant;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->store("OVO", "Transfer via OVO", 1,"ovo.png");
        $this->store("BANK BCA", "Transfer via Rekening Bank BCA", 1,"bca.png");
        $this->store("DANA", "Transfer via akun DANA", 1,"dana.png");
        $this->store("GOPAY", "Transfer via akun Gopay", 1,"gopay.png");
        $this->store("Bitcoin", "Transfer via Bitcoin", 1,"btc.png");
    }

    public function store($name, $desc, $status, $photoPath)
    {
        $photo = "/razky_samples/payment/$photoPath";
        $data = new PaymentMerchant();
        $data->name = $name;
        $data->created_by = 1;
        $data->m_description = $desc;
        $data->status = $status;
        $data->photo = $photo;

        $data->save();
    }

}
