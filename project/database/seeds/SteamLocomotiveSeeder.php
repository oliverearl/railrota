<?php

use App\SteamLocomotive;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SteamLocomotiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locomotives = new SteamLocomotive();
        $time = Carbon::now();

        foreach ($locomotives->getDefaultLocomotives() as $locomotive) {
            DB::table('steam_locomotives')->insert([
                'name'          => $locomotive,
                'description'   => "{$locomotive} description",
                'created_at'    => $time,
                'updated_at'    => $time,
            ]);
        }
    }
}
