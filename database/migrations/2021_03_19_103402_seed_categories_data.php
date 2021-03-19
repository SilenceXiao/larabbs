<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $categories = [
            [
                'name' => '分享',
                'code' => 'C1',
                'description' => '分享创造，分享发现',
            ],
            [
                'name' => '教程',
                'code' => 'C2',
                'description' => '开发技巧、推荐扩展包等',
            ],
            [
                'name' => '问答',
                'code' => 'C3',
                'description' => '请保持友善，互帮互助',
            ],
            [
                'name' => '公告',
                'code' => 'C4',
                'description' => '站点公告',
            ],
        ];
        
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //清空数据
        DB::table('categories')->truncate();
    }
}
