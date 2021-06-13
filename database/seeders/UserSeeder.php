<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate old values
        DB::table('users')->truncate();

        // Generate default users
        for ($i = 1; $i <= 2; $i++) {
            User::factory()->create(
                [
                    'name' => 'olvaso' . $i,
                    'email' => 'olvaso' . $i . '@szerveroldali.hu'
                ]
            );
        }


        // Generate default libarians
        for ($i = 1; $i <= 2; $i++) {
            User::factory()->create(
                [
                    'name' => 'konyvtaros' . $i,
                    'email' => 'konyvtaros' . $i . '@szerveroldali.hu',
                    'is_libarian' => 1
                ]
            );
        }
    }
}
