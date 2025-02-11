<?php

namespace Database\Seeders;

use App\Models\BookRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookRequest::factory()->count(5)->create();
    }
}
