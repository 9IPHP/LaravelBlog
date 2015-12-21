<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;

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
        $subscriberRole = Role::create([
            'name' => '订阅者',
            'slug' => 'subscriber',
        ]);
        $contributorRole = Role::create([
            'name' => '投稿者',
            'slug' => 'contributor',
        ]);
        $authorRole = Role::create([
            'name' => '作者',
            'slug' => 'author',
        ]);
        $editorRole = Role::create([
            'name' => '编辑',
            'slug' => 'editor',
        ]);
        $adminRole = Role::create([
            'name' => '管理员',
            'slug' => 'admin',
        ]);
        // Create Permission
        $createArticlePermission = Permission::create([
            'name' => '发布文章',
            'slug' => 'article.create',
        ]);
        $uploadImagePermission = Permission::create([
            'name' => '上传图片',
            'slug' => 'image.upload',
        ]);
        $manageArticlePermission = Permission::create([
            'name' => '文章管理',
            'slug' => 'article.manage',
        ]);
        $manageCommentPermission = Permission::create([
            'name' => '评论管理',
            'slug' => 'comment.manage',
        ]);
        $manageImagePermission = Permission::create([
            'name' => '图片管理',
            'slug' => 'image.manage',
        ]);
        $manageTagPermission = Permission::create([
            'name' => '标签管理',
            'slug' => 'tag.manage',
        ]);
        $manageUserPermission = Permission::create([
            'name' => '用户管理',
            'slug' => 'user.manage',
        ]);

        $contributorRole->assignPermission($createArticlePermission->id);

        $authorRole->assignPermission($createArticlePermission->id);
        $authorRole->assignPermission($uploadImagePermission->id);

        $editorRole->assignPermission($createArticlePermission->id);
        $editorRole->assignPermission($uploadImagePermission->id);
        $editorRole->assignPermission($manageArticlePermission->id);
        $editorRole->assignPermission($manageCommentPermission->id);
        $editorRole->assignPermission($manageImagePermission->id);
        $editorRole->assignPermission($manageTagPermission->id);

        // Create User
        $admin = User::create([
            'name' => env('ADMIN_NAME', 'Admin'),
            'email' => env('ADMIN_EMAIL', 'admin@laravel.blog'),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'password'))
        ]);
        if(! $admin->save()) {
            Log::info('Unable to create admin '.$admin->username, (array)$admin->errors());
        } else {
            $admin->assignRole($adminRole->id);
            Log::info('Created admin "'.$admin->username.'" <'.$admin->email.'>');
        }
    }
}
