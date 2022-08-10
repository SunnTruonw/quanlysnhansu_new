<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('avatar_path')->nullable();
            $table->integer('parent_id');
            $table->tinyInteger('active')->default(1)->comment('Trạng thái true -> hiển thị, fasle -> ẩn');
            $table->tinyInteger('order')->default(0)->comment('Số thứ tự');
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
        Schema::dropIfExists('categories');
    }
}
