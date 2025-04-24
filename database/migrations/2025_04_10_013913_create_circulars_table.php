<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('circulars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('external_agency')->nullable();
            $table->string('department');
            $table->string('category');
            $table->string('broadcast')->nullable();
            $table->integer('pages');
            $table->date('date');
            $table->integer('read_count')->default(0);
            $table->string('access_group'); // ex: 1,2,3
            $table->string('news_type')->nullable(); // ex: ทั่วไป,ด่วน
            $table->string('highlight')->nullable();
            $table->integer('priority')->default(0);
            $table->integer('display_days')->default(7);
            $table->string('pdf_path')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('circulars');
    }
};
