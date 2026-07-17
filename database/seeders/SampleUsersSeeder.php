<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SampleUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@clemwa.dev'],
            ['name' => 'Editor User', 'email' => 'editor@clemwa.dev'],
            ['name' => 'Support User', 'email' => 'support@clemwa.dev'],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }
    }
}
