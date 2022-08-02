<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('admin123'),
        ]);

        $kasir = User::create([
            'name' => 'kasir',
            'email' => 'kasir@test.com',
            'password' => bcrypt('kasir123'),
        ]);

        $pengurus = User::create([
            'name' => 'pengurus',
            'email' => 'pengurus@test.com',
            'password' => bcrypt('pengurus123'),
        ]);
        
        $admin->assignRole('admin');
        $kasir->assignRole('kasir');
        $pengurus->assignRole('pengurus');
        
    }
}
