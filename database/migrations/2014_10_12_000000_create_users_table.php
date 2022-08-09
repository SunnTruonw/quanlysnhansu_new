<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable()->comment('Mô tả');
            $table->string('avatar_path')->nullable()->comment('Ảnh đại diện');
            $table->text('content')->nullable()->comment('Chi tiết');
            $table->tinyInteger('active')->default(1)->comment('Trạng thái true -> hiển thị, fasle -> ẩn');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
