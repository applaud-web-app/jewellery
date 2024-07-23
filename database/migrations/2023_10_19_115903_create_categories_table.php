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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('cat_name',155)->index();
            $table->string('primary_img',155);
            $table->string('slug',155)->index();
            $table->integer('parent_id')->default(0)->index();
            $table->integer('s_parent_id')->default(0);
            $table->string('meta_title',255);
            $table->string('meta_keywords',255);
            $table->string('meta_description',255);
            $table->string('feature_img',255);
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
