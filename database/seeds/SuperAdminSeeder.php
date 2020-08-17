<?php

use Illuminate\Database\Seeder;
use App\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $id = $user->insertGetId(['name' => 'super-admin',
            'email' => 'admin@mail.ru',
            'password' => password_hash('admin123', 1)]);
        User::find($id)->assignRole('super-admin');
    }
}
