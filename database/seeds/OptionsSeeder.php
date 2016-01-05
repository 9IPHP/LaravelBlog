<?php

use Illuminate\Database\Seeder;
use App\Option;
class OptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        DB::table('options')->delete();
        Option::insert([
            ['label' => '站点名称', 'name' => 'sitename', 'value' => 'Laravel Blog', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['label' => '副标题', 'name' => 'sitedesc', 'value' => 'A Blog Created with Laravel', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['label' => '关键词', 'name' => 'keywords', 'value' => 'Laravel,Blog,PHP', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['label' => '描述', 'name' => 'description', 'value' => 'A Site Created with Laravel', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['label' => '统计代码', 'name' => 'site_analytics', 'value' => '', 'type' => 'textarea', 'created_at' => $now, 'updated_at' => $now],
            ['label' => '微博', 'name' => 'weibo', 'value' => '', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Github', 'name' => 'github', 'value' => '', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Twitter', 'name' => 'twitter', 'value' => '', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Facebook', 'name' => 'facebook', 'value' => '', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
