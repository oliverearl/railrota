<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        // Insert myself first
        DB::table('users')->insert([
            'name' =>                       'Jane',
            'surname' =>                    'Doe',
            'email' =>                      'jane.doe@railrota.com',
            'password' =>                   bcrypt('password'),
            'remember_token' =>             Str::random(10),
            'is_available' =>               true,
            'is_admin' =>                   true,
            'notes' =>                      'Pretty cool guy and doesn\'t afraid of anything.',
            'date_of_last_inspection' =>    $time,
            'created_at' =>                 $time,
            'updated_at' =>                 $time,
        ]);
    }
}
