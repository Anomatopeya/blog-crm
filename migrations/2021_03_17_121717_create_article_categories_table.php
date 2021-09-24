<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->integer('order')->default(1);
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->default('noimage.jpg')->nullable();
            $table->text('name');
            $table->longText('content')->nullable();
            $table->text('short_description')->nullable();
            $table->text('seo_title');
            $table->text('seo_h1')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->unsignedInteger('rgt')->default(0);
            $table->unsignedInteger('lft')->default(0);
            $table->unsignedBigInteger('depth')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('article_categories');
    }
}
