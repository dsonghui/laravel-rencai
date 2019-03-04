<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalentsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('talents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            $table->string('name');
            $table->tinyInteger('nametype')->default(0);
            $table->tinyInteger('sex')->default(0);
            $table->string('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('edu')->nullable()->comment('最高学历');
            $table->tinyInteger('experience')->nullable()->comment('工作经验');
            $table->tinyInteger('marriage')->nullable()->comment('婚姻状况');
            $table->string('address')->nullable()->comment('现居地址');
            $table->string('avatar')->nullable()->comment('头像');
            $table->timestamp('verified_at')->nullable()->comment('账号验证时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talents');
    }
}
