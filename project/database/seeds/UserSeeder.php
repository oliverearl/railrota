<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert myself first
        DB::table('users')->insert([
            'name' =>                       'Oliver',
            'surname' =>                    'Earl',
            'email' =>                      'ole4@aber.ac.uk',
            'password' =>                   bcrypt('password'),
            'remember_token' =>             Str::random(10),
            'is_available' =>               true,
            'is_admin' =>                   true,
            'date_of_last_inspection' =>    Carbon::now()
        ]);
        // Generate users
        factory(App\User::class, 20)->create();
    }
}
