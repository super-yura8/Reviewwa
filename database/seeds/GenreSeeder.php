<?php

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'музыка'],
            ['name' => 'фильм'],
            ['name' => 'сайт'],
            ['name' => 'кафе'],
            ['name' => 'ресторан'],
            ['name' => 'парк'],
            ['name' => 'тц'],
            ['name' => 'место работы'],
            ['name' => 'негатив'],
            ['name' => 'видеоигры'],
            ['name' => 'искусство'],
        ];
        Genre::insert($data);
    }
}
