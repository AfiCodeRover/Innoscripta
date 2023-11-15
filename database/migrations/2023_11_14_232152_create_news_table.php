<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->string('category', '100')->index('category_index');
            $table->string('source', 100)->index('source_index');
            $table->string('author', 200)->index('author_index');
            $table->string('url', 255)->unique();
            $table->text('body');
            $table->dateTime('publish_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
