<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->longText('description')->nullable();
            $table->double('price');
            $table->unsignedBigInteger('quantity')->default(0);
            $table->string('category')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('country_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('state_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('advs');
    }
}
