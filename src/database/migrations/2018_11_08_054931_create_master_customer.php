<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_type', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 65);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('customer', function( Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_type');
            $table->string('name', 65)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('phone', 13)->nullable();
            $table->text('address')->nullable();
            $table->text('location')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('customer_type')
                ->references('id')
                ->on('customer_type')
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
        Schema::dropIfExists('customer');
        Schema::dropIfExists('customer_type');
    }
}
