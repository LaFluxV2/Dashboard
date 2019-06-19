<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_code')->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('user_type', 2)->nullable()
                ->comments('SU - Super Admin, A - Admin, S - Student, P - Parent, E - Employee, O - Other');
            $table->string('phone')->nullable();
            $table->smallInteger('status')->default(1);
            $table->smallInteger('groups')->default(3);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
