<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_images', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger => auto-incrementing primary key
            $table->string('image_path');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreignId('item_id')->references('id')->on('items')->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_images');
    }
};
