<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = new \App\RoleType;
        $time = Carbon::now();

        foreach ($types->getDefaultTypes() as $type) {
            DB::table('role_types')->insert([
                'name'          => $type,
                'description'   => "{$type} description",
                'created_at'    => $time,
                'updated_at'    => $time,
            ]);
        }
    }
}
