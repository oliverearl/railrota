<?php

use App\PoweredLocomotive;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoweredLocomotiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locomotives = new PoweredLocomotive();
        $time = Carbon::now();

        foreach ($locomotives->getDefaultLocomotives() as $locomotive) {
            DB::table('powered_locomotives')->insert([
                'name'          => $locomotive,
                'description'   => "{$locomotive} description",
                'created_at'    => $time,
                'updated_at'    => $time,
            ]);
        }
    }
}
