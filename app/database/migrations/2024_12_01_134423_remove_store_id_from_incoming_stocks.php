<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStoreIdFromIncomingStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incoming_stocks', function (Blueprint $table) {
            
            $table->dropForeign(['store_id']);
            
            $table->dropColumn('store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incoming_stocks', function (Blueprint $table) {
            
            $table->unsignedBigInteger('store_id')->nullable();
            
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }
}
