<?php

use Illuminate\Database\Seeder;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use App\User;

class RoleAndUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create User
        $admin = User::create([
            'name' => env('ADMIN_NAME', 'Admin'),
            'email' => env('ADMIN_EMAIL', 'admin@laravel.blog'),
            'level' => 10,
            'password' => bcrypt(env('ADMIN_PASSWORD', 'password'))
        ]);
        if(! $admin->save()) {
            Log::info('Unable to create admin '.$admin->username, (array)$admin->errors());
        } else {
            Log::info('Created admin "'.$admin->username.'" <'.$admin->email.'>');
        }
    }
}
