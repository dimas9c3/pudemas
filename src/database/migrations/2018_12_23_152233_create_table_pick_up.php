<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePickUp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pick_up', function(Blueprint $table) {
            $table->string('id', 15)->primary();
            $table->unsignedInteger('courier');
            $table->enum('type', ['cash', 'tempo']);
            $table->integer('is_send_to_customer')->comments('1=Ya, 0=Tidak');
            $table->integer('status')->default('3')->comments('3=Tersimpan, 2=job diambil, 1=barang sudah terambil otw balik, 0=selesai');
            $table->text('latitude')->nullable();
            $table->text('longtitude')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('courier')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('pick_up_detail', function(Blueprint $table) {
            $table->increments('id');
            $table->string('pick_up_id', 15);
            $table->unsignedInteger('supplier');
            $table->unsignedInteger('item');
            $table->integer('qty');
            $table->integer('purchase_price');
            $table->integer('is_first_row')->default('0')->comments('Mengecek apakah baris pertama atau tidak');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('pick_up_id')
                ->references('id')
                ->on('pick_up')
                ->onDelete('cascade');

            $table->foreign('supplier')
                ->references('id')
                ->on('supplier')
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
        Schema::dropIfExists('pick_up_detail');
        Schema::dropIfExists('pick_up');
    }
}
