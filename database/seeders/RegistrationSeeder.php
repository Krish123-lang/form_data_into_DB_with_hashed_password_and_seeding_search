<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Added manually
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Registration;
use Faker\Factory as Faker;


class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // for ($i = 0; $i < 10; $i++) {
        //     DB::table('registrations')->insert(
        //         [
        //             'name' => Str::random(10),
        //             'email' => Str::random(10) . '@gmail.com',
        //             'password' => Hash::make('password'),
        //         ]
        //     );
        // }

        // RECOMMENDED
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            $registration = new Registration;
            $registration->name = $faker->name;
            $registration->email = $faker->email;
            $registration->password = Hash::make($faker->password);
            $registration->save();
        }
    }
}
