<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_id' => 1,
                'name' => 'Vic Chang',
                'email' => 'lakingray@gmail.com',
                'avatar' => 'users/December2020/gfJOJ1eZ8eCUJrZcOuMJ.png',
                'email_verified_at' => NULL,
                'password' => '$2y$10$oij8ahhesDrpw9OnwoLn9udglVQIMWTyjh6CBVJxwUslLTQHviA0O',
                'remember_token' => 'MYm4QSBbywLZ84ljD5BUTcKjVNRu0ukTMU1HwulU1Faz1kOEmun4Xb1DSK9w',
                'settings' => '{"locale":"en"}',
                'created_at' => '2020-12-28 00:05:24',
                'updated_at' => '2020-12-28 13:46:45',
            ),
            1 => 
            array (
                'id' => 2,
                'role_id' => 3,
                'name' => 'rex cheng',
                'email' => 'kkob@gmail.com',
                'avatar' => 'users/default.png',
                'email_verified_at' => NULL,
                'password' => '$2y$10$Y63kOB0nRYZyaCyO5j0uj.s4VgWhiMpL4tKN3ppO36SZlRRU.Uz5W',
                'remember_token' => NULL,
                'settings' => NULL,
                'created_at' => '2020-12-28 19:53:45',
                'updated_at' => '2020-12-29 03:49:20',
            ),
            2 => 
            array (
                'id' => 3,
                'role_id' => 3,
                'name' => 'Lebron James',
                'email' => 'lbj@gmail.com',
                'avatar' => 'users/default.png',
                'email_verified_at' => NULL,
                'password' => '$2y$10$qaVpvlztUZwejgniF.6gfeFeVLS/KrCsBNiMtCep59T0FeN2ZHydW',
                'remember_token' => NULL,
                'settings' => NULL,
                'created_at' => '2020-12-28 19:53:57',
                'updated_at' => '2020-12-29 03:43:04',
            ),
        ));
        
        
    }
}