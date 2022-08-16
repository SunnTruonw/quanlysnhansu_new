<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoomTableSeeder::class,
            UsersTableSeeder::class,
            DocummentTableSeeder::class,
        ]);
    }
}


// http://192.168.1.17:8080/quanlysnhansu_demo/public/admin
// tk: test@gmail.com
// mk: 123456789

// http://192.168.1.17:8080/phpmyadmin/

// https://github.com/SunnTruonw/quanlynhansu



