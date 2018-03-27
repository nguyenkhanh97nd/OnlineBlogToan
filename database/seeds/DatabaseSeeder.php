<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'username'=>'blogtoan',
            'name'=>'Khánh Nguyễn',
            'email' => 'blogtoan.com@gmail.com',
            'gender'=>1,
            'password' => Hash::make('blogtoan'),
            'level' =>1,
            'status'=>1,
        ]);
    }
}
