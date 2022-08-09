<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocummentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documments', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->tinyInteger('sex')->default(1)->comment('Giới tính true->Nam, false->Nữ');
            $table->string('address');
            $table->date('date_working')->comment('Ngày vào làm');
            $table->date('date_off')->comment('Ngày nghỉ việc');
            $table->integer('user_id');
            $table->string('image_path')->nullable()->comment('Ảnh căn cước');
            $table->string('file')->nullable()->comment('File tài liệu');;
            $table->tinyInteger('active')->default(1)->comment('Trạng thái true -> hiển thị, fasle -> ẩn');
            $table->tinyInteger('order')->default(0)->comment('Số thự tự');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documments');
    }
}
