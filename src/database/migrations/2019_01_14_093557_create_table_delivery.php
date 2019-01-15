<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDelivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery', function(Blueprint $table){
        	$table->string('id', 15)->primary();
        	$table->unsignedInteger('customer');
            $table->unsignedInteger('courier');
            $table->integer('send_cost')->default('0')->nullable();
            $table->integer('is_pickup_first')->comments('1=Ya, 0=Tidak');
            $table->integer('status')->default('3')->comments('3=Tersimpan, 2=job diambil, 1=barang sudah terambil otw balik, 0=selesai');
            $table->text('location')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('courier')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('customer')
                ->references('id')
                ->on('customer')
                ->onDelete('cascade');
        });

        Schema::create('delivery_detail', function(Blueprint $table) {
            $table->increments('id');
            $table->string('delivery_id', 15);
            $table->unsignedInteger('item');
            $table->integer('qty');
            $table->integer('selling_price');
            $table->integer('is_first_row')->default('0')->comments('Mengecek apakah baris pertama atau tidak');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('delivery_id')
                ->references('id')
                ->on('delivery')
                ->onDelete('cascade');

            $table->foreign('item')
                ->references('id')
                ->on('item')
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
        Schema::dropIfExists('delivery_detail');
        Schema::dropIfExists('delivery');
    }
}
