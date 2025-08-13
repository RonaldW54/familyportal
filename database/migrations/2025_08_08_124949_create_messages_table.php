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
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('admin_id')->constrained('users'); // Wer hat die Nachricht geschrieben?
        $table->foreignId('user_id')->nullable()->constrained('users'); // Für wen ist sie? (null = für alle)
        $table->text('content');
        $table->timestamp('read_at')->nullable(); // Wann wurde sie gelesen?
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
