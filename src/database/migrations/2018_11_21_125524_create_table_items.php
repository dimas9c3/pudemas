<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('item_category1', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 65);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('item_category2', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 65);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('item', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_category1');
            $table->unsignedInteger('item_category2');
            $table->string('name', 65);
            $table->integer('purchase_price');
            $table->integer('selling_price');
            $table->string('image', 65)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('item_category1')
                ->references('id')
                ->on('item_category1')
                ->onDelete('cascade');

            $table->foreign('item_category2')
                ->references('id')
                ->on('item_category2')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
        Schema::dropIfExists('item_category1');
        Schema::dropIfExists('item_category2');
    }
}
