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
            ['label' => '站点名称', 'name' => 'sitename', 'value' => 'Laravel Blog', 'created_at' => $now, 'updated_at' => $now],
            ['label' => '关键词', 'name' => 'keywords', 'value' => 'Laravel,Blog,PHP', 'created_at' => $now, 'updated_at' => $now],
            ['label' => '描述', 'name' => 'description', 'value' => 'A Site Created with Laravel', 'created_at' => $now, 'updated_at' => $now],
            ['label' => '统计代码', 'name' => 'site_analytics', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
            ['label' => '微博', 'name' => 'weibo', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Github', 'name' => 'github', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Twitter', 'name' => 'twitter', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Facebook', 'name' => 'facebook', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
