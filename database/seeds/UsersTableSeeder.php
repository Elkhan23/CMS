<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'elkhan@decordtech.com')->first();
        if(!$user){
            User::create([
            'name'=> 'Elkhan Khalilov',
            'email'=>'elkhan@decordtech.com',
            'role'=>'admin',
            'password'=>Hash::make('password')
        ]);
    }
    }
}
