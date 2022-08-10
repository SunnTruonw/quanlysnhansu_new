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
            $table->string('email');
            $table->string('password');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->integer('room_id');
            $table->integer('city_id');
            $table->integer('district_id');
            $table->string('avatar_path')->nullable()->comment('Ảnh đại diện');
            $table->tinyInteger('sex')->default(1)->comment('Giới tính true->Nam, false->Nữ');
            $table->enum('role', ['user', 'admin'])->default('user')->comment('Chức vụ'); 
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
