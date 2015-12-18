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
        // Create Roles
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => '',
            'level' => 10
        ]);
        $editorRole = Role::create([
            'name' => '编辑',
            'slug' => 'editor',
            'description' => '',
            'level' => 5
        ]);
        $authorRole = Role::create([
            'name' => '作者',
            'slug' => 'author',
            'description' => '',
            'level' => 3
        ]);
        $contributorRole = Role::create([
            'name' => '投稿者',
            'slug' => 'contributor',
            'description' => '',
            'level' => 2
        ]);
        $subscriberRole = Role::create([
            'name' => '订阅者',
            'slug' => 'subscriber',
            'description' => '',
            'level' => 1
        ]);
        $banRole = Role::create([
            'name' => '禁用',
            'slug' => 'ban',
            'description' => '',
            'level' => -1
        ]);

        // Create User
        $admin = User::create([
            'name' => env('ADMIN_NAME', 'Admin'),
            'email' => env('ADMIN_EMAIL', 'admin@laravel.blog'),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'password'))
        ]);
        if(! $admin->save()) {
            Log::info('Unable to create admin '.$admin->username, (array)$admin->errors());
        } else {
            Log::info('Created admin "'.$admin->username.'" <'.$admin->email.'>');
        }
        // Attach Roles to user
        $admin->attachRole($adminRole);

        // Create Permissions
        /*$uploadImagePermission = Permission::create([
            'name' => '上传图片',
            'slug' => 'upload.image',
            'description' => '', // optional
        ]);
        $authorRole->attachPermission($createTagsPermission);

        $createTagsPermission = Permission::create([
            'name' => '创建标签',
            'slug' => 'create.tags',
            'description' => '创建文章标签', // optional
        ]);
        $authorRole->attachPermission($createTagsPermission);*/
    }
}
