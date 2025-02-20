<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $citizenPermissions = ['request books', 'view books', 'review books'];
        $adminPermissions = ['request books', 'view books', 'manage books', 'view all requests', 'confirm reception', 'manage authors', 'manage publishers'];
        $allPermissions = array_unique(array_merge($citizenPermissions, $adminPermissions));

        $this->CreatePermissions($allPermissions);
        $this->CreateRolesWithPermissions(RolesEnum::ADMIN, $adminPermissions);
        $this->CreateRolesWithPermissions(RolesEnum::CITIZEN, $citizenPermissions);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RolesEnum::ADMIN); // removed citizen so can restrict review to only citizen
//
//        for ($i = 0; $i < 10; $i++) {
//            $this->call(PublisherSeeder::class);
//            $this->call(BookSeeder::class);
//            $this->call(AuthorSeeder::class);
//            $this->call(BookRequestSeeder::class);
//        }
    }

    protected function CreatePermissions(array $permissions): void
    {
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }

    protected function CreateRolesWithPermissions(RolesEnum $role, array $permissions): void {
        $newRole = Role::create(['name' => $role]);
        $newRole->syncPermissions($permissions);
    }
}
