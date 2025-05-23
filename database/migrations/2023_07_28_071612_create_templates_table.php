<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('category_id');
            $table->json('some_category_id')->nullable();
            $table->string('file_path')->unique();
            $table->string('db_path')->unique();
            $table->boolean('status')->default(true)->nullable();
            $table->longText('short_text')->nullable();
            $table->longText('text')->nullable();
            $table->string('photo');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
