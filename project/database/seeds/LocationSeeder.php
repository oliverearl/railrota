<?php

use App\Location;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = new Location();
        $time = Carbon::now();

        foreach ($locations->getDefaultLocations() as $location) {
            DB::table('locations')->insert([
                'name'          => $location,
                'description'   => "{$location} description",
                'created_at'    => $time,
                'updated_at'    => $time,
            ]);
        }
    }
}
