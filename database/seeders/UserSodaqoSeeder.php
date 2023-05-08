<?php

namespace Database\Seeders;

use App\Models\UserSodaqo;
use Illuminate\Database\Seeder;
use Faker\Factory;
class UserSodaqoSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        foreach (range(1, 500) as $index) {
            $status = rand(0, 2);

            $nominalNet = null;
            $notesAdmin = null;

            $userId = 49;
//            $userId = rand(1, 19);
            if ($userId === 2) {
                $userId = 47;
            }


            if ($status !== 0) {
                $nominalNet = 50000+$index;
                $notesAdmin = $faker->sentence();
            }

            UserSodaqo::create([
                "sodaqo_id" => [1, 3, 4, 5][mt_rand(0, 3)],
                "user_id" => $userId,
                "payment_id" => rand(11, 15),
//                "payment_id" => 13,
                "photo" => $faker->imageUrl(),
//                "nominal" => rand(10000, 500000),
                "nominal" => 10000+$index,
                "nominal_net" => $nominalNet,
                "is_anonym" => rand(0, 1) ? "0" : "1",
                "is_whatsapp_enabled" => rand(0, 1) ? "1" : "0",
                "doa" => $faker->sentence(),
                "notes_admin" => $notesAdmin,
                "status" => $status,
                "created_at" => $faker->dateTimeBetween('2020-01-01', '2021-12-31'),
                "updated_at" => $faker->dateTimeBetween('2020-01-01', '2021-12-31'),
            ]);
        }
    }
}
