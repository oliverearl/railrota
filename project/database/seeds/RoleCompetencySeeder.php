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
            $keys = [];
            $defaults = [];
            switch (strtolower($type->name)) {
                case 'driver - diesel and electric':
                    $keys =     array_keys($connection->getPoweredDefaults());
                    $values =   $connection->getPoweredDefaults();
                    break;
                case 'driver - steam locomotive':
                    $keys =     array_keys($connection->getSteamDefaults());
                    $values =   $connection->getSteamDefaults();
                    break;
                case 'controller':
                case 'guard':
                case 'blockman':
                default:
                    $keys =     array_keys($connection->getControllerDefaults());
                    $values =   $connection->getControllerDefaults();
                    break;
            }
            if (!empty($keys) || !empty($values)) {
                foreach ($keys as $key) {
                    DB::table('role_competencies')->insert([
                        'name'          => $key,
                        'description'   => "{$key} description",
                        'role_type_id'  => $type->id,
                        'tier'          => $values[$key],
                        'created_at'    => $time,
                        'updated_at'    => $time,
                    ]);
                }
            } else {
                die('Could not retrieve data correctly.');
            }
        }
    }
}
