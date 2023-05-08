<?php

namespace Database\Seeders;

use App\Models\SodaqoCategory;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class SodaqoCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->store("Masjid & Tempat Ibadah","","Logo Masjid & Tempat Ibadah.png");
        $this->store("Bencana Alam","","Logo Bencana Alam.png");
        $this->store("Pendidikan","","Logo Pendidikan.png");
        $this->store("Anak Yatim","","Anak Yatim.png");
        $this->store("Sarana dan Infrastruktur","","Logo Sarana & Infra.png");
        $this->store("Lingkungan","","Lingkungan.png");
        $this->store("Sosial","","Logo Sosial.png");
        $this->store("Lainnya","","Lainnya.png");
    }

    public function store($title,$content,$photo_path)
    {
//        dd($request->all());
        $data = new SodaqoCategory();
        $data->name = $title;
        $data->description = $content;
        $data->photo="/razky_samples/sodaqo_cat/$photo_path";
        $data->save();
    }
}
