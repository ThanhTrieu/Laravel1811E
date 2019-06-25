<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            //Increments: khoa chinh - tu dong tang
            //big : so nguyen vo cung lon
            // in : integer 
            // so nguyen khong am
            // $table->bigIncrements('id');
            $table->increments('id')->unsigned();
            // varchar : max 100 charater
            // username: khong trung nhau
            $table->string('username', 60)->unique();
            $table->string('password',60);
            // email khong trung nhau
            $table->string('email',60)->unique();
            // gan gia tri mac dinh
            $table->tinyInteger('role')->default(-1);
            $table->tinyInteger('status')->default(1);
            $table->string('phone', 20);
            // address duoc phep rong
            $table->text('address')->nullable();
            $table->timestamps();
            // created_at va updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
