<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBruteForceProtection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add columns to users table for brute force protection
        Schema::table('users', function (Blueprint $table) {
            $table->integer('login_attempts')->default(0)->after('last_login');
            $table->dateTime('last_login_attempt')->nullable()->after('login_attempts');
            $table->dateTime('locked_until')->nullable()->after('last_login_attempt');
        });

        // Create table for login attempts tracking
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('username_or_email');
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->boolean('successful')->default(false);
            $table->string('reason')->nullable();
            $table->dateTime('attempted_at');
            $table->timestamps();

            $table->index('username_or_email');
            $table->index('ip_address');
            $table->index('attempted_at');
        });

        // Create table for suspicious activity alerts
        Schema::create('suspicious_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('username_or_email')->nullable();
            $table->string('ip_address');
            $table->string('activity_type'); // 'multiple_failures', 'account_locked', 'unusual_location'
            $table->text('details')->nullable();
            $table->boolean('alert_sent')->default(false);
            $table->dateTime('alerted_at')->nullable();
            $table->dateTime('created_at');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('user_id');
            $table->index('ip_address');
            $table->index('activity_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_attempts');
        Schema::dropIfExists('suspicious_activities');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login_attempts', 'last_login_attempt', 'locked_until']);
        });
    }
}
