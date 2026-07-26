<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        Organization::firstOrCreate(
            [
                'slug' => 'amikom-eventhub',
            ],
            [
                'name'   => 'Amikom EventHub',
                'email'  => 'admin@eventhub.com',
                'logo'   => null,
                'status' => 'approved',
            ]
        );
    }
}