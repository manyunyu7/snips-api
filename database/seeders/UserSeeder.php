<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->insertUser(
            'Muhammad Firriezky',
            '1',
            '088223738109',
            'firriezky@gmail.com',
            '/razky_samples/firriezky.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            'Satu Enam Delapan',
            '1',
            '082113530950',
            '168@gmail.com',
            '/razky_samples/firriezky.jpg',
            bcrypt('password')
        );

        $this->insertUser(
            'Super Admin',
            '1',
            '088223738709',
            'admin@gmail.com',
            '/razky_samples/firriezky.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            'Akun Kelurahan',
            '4',
            '081234567890',
            'kelurahan@gmail.com',
            '/razky_samples/firriezky.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            'Akun Kecamatan',
            '5',
            '081234567891',
            'kecamatan@gmail.com',
            '/razky_samples/firriezky.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            'Raffey Cassidy',
            '3',
            '082113530900',
            'cassidy@gmail.com',
            '/razky_samples/cassidy.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            'Valezka',
            '3',
            '082113530901',
            'valezka@gmail.com',
            '/razky_samples/valezka.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            'Anya Taylor Joy',
            '3',
            '082113530902',
            'anya@gmail.com',
            '/razky_samples/anya.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            'Ismi Nur Hidayah',
            '3',
            '082113530903',
            'ismin@gmail.com',
            '/razky_samples/ismi.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            'Ahmad Zaky',
            '2',
            '088223738702',
            'ahmadzaky@gmail.com',
            '/razky_samples/ahmad_zaky.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            "Kiko Mizuhara",
            "2",
            '088223738703',
            'kiko@gmail.com',
            '/razky_samples/kiko_mizu.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            "Sandhika Galih",
            "2",
            '088223738704',
            'sandhika@gmail.com',
            '/razky_samples/sandhika.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            "Eko Khannedy",
            "2",
            '088223738705',
            'khannedy@gmail.com',
            '/razky_samples/ek_khannedy.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            "Shantika Sandyakala",
            "2",
            '088223738706',
            'shantika@gmail.com',
            '/razky_samples/santhika.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            "Clarissa Divya",
            "2",
            '088223738707',
            'clarissa@gmail.com',
            '/razky_samples/santhika.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            "Marta Klyrova",
            "2",
            '088223738708',
            'marta@gmail.com',
            '/razky_samples/marta_klyrova.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            "Yua Sakura",
            "2",
            '088223738710',
            'yua_sakura@gmail.com',
            '/razky_samples/yua_sakura.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            "Shizi Manyunyu",
            "2",
            '088223738711',
            'manyunyu@gmail.com',
            '/razky_samples/manyunyu1.jpg',
            bcrypt('998877')
        );

        $this->insertUser(
            "Ai Zhan",
            "2",
            '088223738712',
            'aizhan@gmail.com',
            '/razky_samples/manyunyu2.jpg',
            bcrypt('998877')
        );

    }

    function insertUser(
        $name, $role, $contact, $email, $photo, $password
    )
    {
        $user = new User();
        $user->name = $name;
        $user->role = $role;
        $user->contact = $contact;
        $user->email = $email;
        $user->photo = $photo;
        $user->password = $password;
        $user->save();
    }
}
