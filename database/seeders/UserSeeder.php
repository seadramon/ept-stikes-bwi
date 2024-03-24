<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use DateTime;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() < 1) {
        	User::insert([
        		[
        			'name' => 'SuperAdmin',
                    'email' => 'admin@stikesbwi.com',
                    'role' => 'administrator',
                    'password' => Hash::make('123456'),
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        		[
        			'name' => 'Pengawas',
                    'email' => 'pengawas@stikesbwi.com',
                    'role' => 'pengawas',
                    'password' => Hash::make('123456'),
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        		[
        			'name' => 'Peserta1',
                    'email' => 'peserta@stikesbwi.com',
                    'role' => 'peserta',
                    'password' => Hash::make('123456'),
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        	]);
        }
    }
}
