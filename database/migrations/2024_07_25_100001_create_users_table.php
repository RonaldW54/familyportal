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
// In der create_users_table Migration...
	Schema::create('users', function (Blueprint $table) {
    		$table->id();
    		$table->string('name');
    		$table->string('email')->unique();
    		$table->timestamp('email_verified_at')->nullable();
    		$table->string('password');

    // --- UNSERE NEUEN SPALTEN ---
    		$table->foreignId('family_id')->nullable()->constrained()->onDelete('set null'); // Jeder User gehört zu einer Familie
    		$table->string('status')->default('pending'); // z.B. 'pending', 'active', 'rejected'
    		$table->boolean('is_family_head')->default(false); // Ist dieser User ein Familienoberhaupt?
    		$table->boolean('isAdmin')->default(false); // Ist dieser User ein Admin?
    // --- ENDE NEUE SPALTEN ---

    		$table->rememberToken();
    		$table->timestamps();
	});

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
