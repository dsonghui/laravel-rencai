<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->string('type')->comment('招聘类型');
            $table->string('title')->comment('职位标题');
            $table->string('desc')->comment('职位描述');
            $table->string('position')->comment('职位类别');
            $table->string('job_type')->comment('职位类型(全职,兼职)');
            $table->string('job_person_no')->nullable()->comment('招聘人数');
            $table->string('job_address')->comment('工作地点');
            $table->string('job_salary')->comment('工作薪资');

            $table->string('work_years')->nullable()->comment('工作年限');
            $table->string('work_edu')->nullable()->comment('学历要求');

            $table->string('link_user')->nullable()->comment('联系人');
            $table->string('link_phone')->nullable()->comment('联系电话');
            $table->string('link_email')->nullable()->comment('联系邮箱');
            $table->string('link_wechat')->nullable()->comment('联系微信');

            $table->timestamp('banned_at')->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
