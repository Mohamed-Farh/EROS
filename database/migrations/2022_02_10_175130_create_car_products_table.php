<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->longText('description')->nullable();
            $table->text('address')->nullable();
            $table->string('year');
            $table->string('color');
            $table->boolean('rent')->default(false);
            $table->string('price');
            $table->boolean('manual')->default(false);
            $table->string('distance');
            $table->string('motor');
            $table->string('sound');
            $table->string('seat');
            $table->string('phone')->nullable();
            $table->foreignId('car_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_type_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('car_products');
    }
}
