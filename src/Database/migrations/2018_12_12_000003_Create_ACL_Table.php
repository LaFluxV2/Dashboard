<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateACLTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('acl_permission')) {
            Schema::create('acl_permission', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('role_id');
                $table->string('menu_text', 50);
                $table->string('link', 255);
                $table->string('icon', 100)->nullable();
                $table->string('acl_key', 255);
                $table->smallInteger('parent_menu')->default(0);
                $table->smallInteger('level')->nullable();
                $table->smallInteger('ordering');
                $table->smallInteger('adding')->default(0);
                $table->smallInteger('edit')->default(0);
                $table->smallInteger('view')->default(0);
                $table->smallInteger('trash')->default(0);
                $table->smallInteger('approval_level_1')->default(0);
                $table->smallInteger('approval_level_2')->default(0);

                $table->string('vendor', 255)->nullable();
                $table->string('namespace', 255)->nullable();
                $table->string('model', 255)->nullable();


                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        if (Schema::hasTable('acl_permission')) {
            Schema::drop('acl_permission');
        }
    }
}
