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
    Schema::create('family_report', function (Blueprint $table) {
        $table->foreignId('report_id')->constrained()->onDelete('cascade');
        $table->foreignId('family_id')->constrained()->onDelete('cascade');
        $table->primary(['report_id', 'family_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_report_pivot');
    }
};
