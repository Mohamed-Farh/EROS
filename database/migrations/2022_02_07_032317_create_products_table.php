<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->longText('description')->nullable();
            $table->double('price');
            $table->unsignedBigInteger('quantity')->default(0);
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->boolean('featured')->default(false);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('country_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('state_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('status')->default(true);
            $table->boolean('admin_check')->default(false);
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
        Schema::dropIfExists('products');
    }
}
