<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $users = User::factory()->create([
        //     'email' => 'john.doe@email.com',
        //     'password' => 'P@ssword1234'
        // ]);

        $response = Http::timeout(30)->get('https://jsonplaceholder.typicode.com/users');

        if (! $response->successful()) {
            $this->command?->error('Failed to fetch users from JSONPlaceholder.');
            return;
        }

        $users = $response->json();

        foreach ($users as $item) {
            $user = User::updateOrCreate(
                ['id' => $item['id']],
                [
                    'name' => $item['name'],
                    'username' => $item['username'],
                    'email' => $item['email'],
                    'phone' => $item['phone'] ?? null,
                    'website' => $item['website'] ?? null,
                    'password' => Hash::make('P@ssword1234'),
                ]
            );

            if ($user) {
                UserAddress::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'street' => data_get($item, 'address.street'),
                        'suite' => data_get($item, 'address.suite'),
                        'city' => data_get($item, 'address.city'),
                        'zipcode' => data_get($item, 'address.zipcode'),
                        'lat' => data_get($item, 'address.geo.lat'),
                        'lng' => data_get($item, 'address.geo.lng'),
                    ]
                );

                UserCompany::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'name' => data_get($item, 'company.name'),
                        'catch_phrase' => data_get($item, 'company.catchPhrase'),
                        'bs' => data_get($item, 'company.bs'),
                    ]
                );
            }
        }

        $this->command?->info('Users seeded successfully.');
    }
}
