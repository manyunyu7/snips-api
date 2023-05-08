<?php

namespace Database\Seeders;

use App\Models\PaymentMerchant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(DonationAccountSeeder::class);
//        $this->call(ProgramSeeder::class);
        $this->call(UserSodaqoSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
