<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('city_tag')->default(false)->nullable();
            $table->string('thumbnail')->default('noimage.jpg')->nullable();
            $table->longText('content')->nullable();
            $table->text('short_description')->nullable();
            $table->text('seo_title');
            $table->text('seo_h1')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('faq')->nullable();
            $table->text('faq_title')->nullable();
            $table->text('map')->nullable();
            $table->integer('parent_id')->nullable();
            $table->unsignedInteger('rgt')->default(0);
            $table->unsignedInteger('lft')->default(0);
            $table->unsignedBigInteger('depth')->default(1);
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
        Schema::dropIfExists('tags');
    }
}
