<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishlistItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishlist_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('wishlist_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('price', 20, 2);
            $table->string('currency');
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->boolean('bought')->default(false);
            $table->bigInteger('bought_by_user_id')->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishlist_items');
    }
}
