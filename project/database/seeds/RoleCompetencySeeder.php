<?php

use App\RoleCompetency;
use App\RoleType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleCompetencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $connection = new RoleCompetency();
        $roleTypes = RoleType::all();
        $time = Carbon::now();

        foreach ($roleTypes as $type) {
            $defaults = [];
            switch (strtolower($type->name)) {
                case 'controller':
                case 'guard':
                case 'blockman':
                    $defaults = $connection->getControllerDefaults();
                    break;
                case 'driver - diesel and electric':
                    $defaults = $connection->getPoweredDefaults();
                    break;
                case 'driver - steam locomotive':
                    $defaults = $connection->getSteamDefaults();
                    break;
                default:
                    break;
            }
            foreach ($defaults as $default) {
                DB::table('role_competencies')->insert([
                    'name'          => $default,
                    'description'   => "{$default} description",
                    'role_type_id'  => $type->id,
                    'created_at'    => $time,
                    'updated_at'    => $time,
                ]);
            }
        }
    }
}
