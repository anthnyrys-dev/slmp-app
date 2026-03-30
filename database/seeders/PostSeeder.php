<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::timeout(30)->get('https://jsonplaceholder.typicode.com/posts');

        if (! $response->successful()) {
            $this->command?->error('Failed to fetch users from JSONPlaceholder.');
            return;
        }

        $posts = $response->json();
        $users = [];

        foreach ($posts as $item) {
            $userId = $item['userId'];

            if (!isset($users[$userId])) {
                $users[$userId] = User::query()->find($userId);
            }

            $user = $users[$userId] ?? null;

            if (!$user) {
                continue;
            }

            Post::updateOrCreate(
                ['id' => $item['id']],
                [
                    'user_id' => $userId,
                    'title' => $item['title'],
                    'body' => $item['body'],
                ]
            );
        }

        $this->command?->info('Posts seeded successfully.');
    }
}
