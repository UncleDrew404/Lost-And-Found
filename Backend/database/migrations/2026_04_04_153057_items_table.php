<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger => auto-incrementing primary key
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['lost', 'found']);
            $table->enum('status', ['active', 'resolved'])->default('active');
            $table->string('location');
            $table->dateTime('date_occured');
            $table->string('contact_info');
            $table->string('image_path')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
