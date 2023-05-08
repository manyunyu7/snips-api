<?php

namespace Database\Seeders;

use App\Models\Sodaqo;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete rows with id > 10
        DB::delete('delete from sodaqos where id > 10');

        // Reset the auto-increment value to 10
        DB::statement('ALTER TABLE sodaqos AUTO_INCREMENT = 10');

        $faker = Factory::create('id_ID');
        for ($i = 0; $i < 200; $i++) {
            // Generate a random name for the Sodaqo
            $name = $this->generateRandomName();

            // Append a random 3-digit number to the name
            $name .= ' ' . $i;

            // Generate a random category ID between 1 and 8
//            $categoryId = mt_rand(1, 8);
            $categoryId = 3;

            // Generate a random admin fee percentage between 0.0 and 2.5
            $adminFeePercentage = mt_rand(0, 250) / 100;

            // Generate a random photo URL using Faker
            $photo = $this->getImage();

            // Generate a random time limit for the Sodaqo
            $timeLimit = $this->generateRandomTimeLimit();

            // Generate a random fundraising target or null
            $fundraisingTarget = mt_rand(0, 100) < 50 ? null : mt_rand(3000000, 15000000);

            $sodaqo = new Sodaqo([
                'owner_id' => 2,
                'category_id' => $categoryId,
                'fundraising_target' => $fundraisingTarget,
                'admin_fee_percentage' => $adminFeePercentage,
                'name' => $name,
                'time_limit' => $timeLimit,
                'story' => $this->generateRandomArticleContent(),
                'status' => 1,
                'is_deleted' => null,
                'photo' => $photo,
            ]);

            $sodaqo->save();
        }
    }

    /**
     * Generate a random name for the Sodaqo.
     *
     * @return string
     */
    protected function generateRandomName()
    {
        $names = [
            'Warung Uncle Mutho',
            'Kegiatan Olahraga Anak',
            'Pengajian Mingguan',
            'Buka Puasa Bersama',
            'Pemulihan Sosial',
            'Seminar Kewirausahaan',
            'Workshop Musik',
            'Pertemuan Keluarga Besar',
            'Bencana Alam',
            'Pembangunan Masjid',
            'Konservasi Lingkungan',
            'Pendidikan Anak Yatim',
            'Pembangunan Rumah Susun',
            'Bantuan Sosial',
            'Pemberdayaan Ekonomi Masyarakat',
            'Festival Seni dan Budaya',
            'Pertunjukan Musik',
            'Maraton Olahraga',
            'Acara Donasi Darah',
            'Pertunjukan Teater',
            'Seminar Kesehatan',
            'Pameran Seni',
            'Acara Doa Bersama',
            'Pertunjukan Tari',
            'Festival Makanan',
            'Festival Film',
            'Pertunjukan Stand-Up Comedy',
        ];

        return $names[array_rand($names)];
    }

    /**
     * Generate a random time limit for the Sodaqo.
     *
     * @return string
     */
    protected function generateRandomTimeLimit()
    {
        // Generate a random number of days in the future to set as the time limit
        $days = mt_rand(1, 365);

        return date('Y-m-d', strtotime("+{$days} days"));
    }


    function generateRandomArticleContent($numParagraphs = 5)
    {
        $faker = Factory::create('id_ID');

        $paragraphs = [];
        for ($i = 0; $i < $numParagraphs; $i++) {
            $paragraphs[] = '<p>' . $faker->paragraph . '</p>';
        }

        return implode("\n", $paragraphs);
    }

    private function getImage()
    {
        $x = array(
            "http://127.0.0.1:2612/web_files/sodaqo/1669425934.jpg"
        );

        // Generate a random index between 0 and the number of images in the list
        $randomIndex = rand(0, count($x) - 1);

        // Get the image URL at the random index
        $imageUrl = $x[$randomIndex];

        // Return the image URL
        return $imageUrl;
    }
}
