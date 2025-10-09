<?php

// it extends table user with 'google_access_token', 'google_refresh_token', etc. Used for google access, for example using Socialite
// GOOGLE_ACCESS_TOKEN ives 1 hour only, so we will dynamically regenerate it using GOOGLE_REFRESH_TOKEN. But GOOGLE_ACCESS_TOKEN is used to getting access
// we save this values in App\Http\Controllers\Socialite\SocialiteGoogleAuthController -> googleLoginCallback()

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('google_access_token')->nullable();
            $table->text('google_refresh_token')->nullable();
            $table->string('google_user_email')->nullable();  // VARCHAR(255)
            $table->timestamp('google_expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_access_token', 'google_refresh_token', 'google_expires_at']);
        });
    }
};
