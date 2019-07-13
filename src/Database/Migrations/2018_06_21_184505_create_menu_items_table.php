<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned()->index()->nullable();
            $table->integer('item_id')->unsigned()->index()->nullable();
            $table->integer('position')->default(0);
            $table->string('type')->nullable()->default(null);
            $table->string('name');
            $table->text('action')->default(null)->nullable();
            $table->text('options')->default(null)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
