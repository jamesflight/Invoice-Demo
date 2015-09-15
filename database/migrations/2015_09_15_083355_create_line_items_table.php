<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_items', function ($table) {
            $table->increments('id')->unsigned()->unique();
            $table->integer('invoice_id')->unsigned()->index()->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->string('name');
            $table->integer('amount');
            $table->double('discount');
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
        Schema::drop('line_items');
    }
}
