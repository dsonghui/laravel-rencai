<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanysTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('companys', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            $table->string('name');
            $table->string('shortname')->nullable();
            $table->integer('hy')->comment('行业')->default(0);
            $table->integer('pr')->comment('性质')->default(0);
            $table->integer('mun')->comment('规模')->default(0);
            $table->integer('provinceid')->nullable();
            $table->integer('cityid')->nullable();
            $table->integer('three_cityid')->nullable();
            $table->string('address', 150)->comment('地址')->nullable();
            $table->string('linkman')->comment('联系人')->nullable();
            $table->string('linkphone')->comment('联系手机')->nullable();
            $table->string('linkmail')->comment('联系邮箱')->nullable();
            $table->string('lat')->nullable();
            $table->string('lnt')->nullable();
            $table->integer('hits')->default(0);
            $table->timestamp('verified_at')->nullable()->comment('企业验证时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companys');
    }
}
