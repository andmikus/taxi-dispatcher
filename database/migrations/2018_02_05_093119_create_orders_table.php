<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('origin_address');
            $table->json('origin_location');
            $table->string('destination_address');
            $table->json('destination_location');
            $table->time('start_time');
            $table->integer('driver_id')->unsigned();
            $table->string('passenger_phone')->nullable();
            $table->enum('status', ['new', 'processing', 'completed'])->default('new');
            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('orders');
        Schema::enableForeignKeyConstraints();
    }
}
