<?php

use App\RoleType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = new RoleType;
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
