<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Guest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(
        EventSeeder::class,
    );
        $this->call(
        GuestSeeder::class,
    );
        $this->call(
        RegistrationSeeder::class,
    );
    }
}
