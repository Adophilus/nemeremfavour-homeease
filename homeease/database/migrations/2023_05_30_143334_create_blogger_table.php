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
        // Create the bloggers table
        Schema::create('bloggers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('school');
            $table->boolean('verified')->default(false);
            $table->boolean('top_blogger')->default(false);
            $table->timestamps();
        });

        // Create the blog posts table
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blogger_id');
            $table->string('title');
            $table->text('content');
            $table->integer('likes')->default(0);
            $table->integer('comments')->default(0);
            $table->timestamps();

            $table->foreign('blogger_id')->references('id')->on('bloggers')->onDelete('cascade');
        });

        // Create the likes table
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blogger_id');
            $table->unsignedBigInteger('blog_post_id');
            $table->timestamps();

            $table->foreign('blogger_id')->references('id')->on('bloggers')->onDelete('cascade');
            $table->foreign('blog_post_id')->references('id')->on('blog_posts')->onDelete('cascade');
        });

        // Create the comments table
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blogger_id');
            $table->unsignedBigInteger('blog_post_id');
            $table->text('content');
            $table->timestamps();

            $table->foreign('blogger_id')->references('id')->on('bloggers')->onDelete('cascade');
            $table->foreign('blog_post_id')->references('id')->on('blog_posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the tables in reverse order
        Schema::dropIfExists('comments');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('bloggers');
    }
};
