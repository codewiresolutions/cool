<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCommentLikesForGuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->string('ip_address')->nullable();
            $table->string('session_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {  Schema::table('comment_likes', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable(false)->change(); // Reverse: make non-nullable (adjust as needed)
        $table->dropColumn('ip_address');
        $table->dropColumn('session_id');
    });
    }
}
