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
        Schema::create('family_media', function (Blueprint $table) {
            // Fremdschlüssel zur 'media'-Tabelle. Wenn ein Medium gelöscht wird,
            // werden auch die Freigaben dafür gelöscht (onDelete('cascade')).
            $table->foreignId('media_id')->constrained('media')->onDelete('cascade');

            // Fremdschlüssel zur 'families'-Tabelle. Wenn eine Familie gelöscht wird,
            // werden auch die Freigaben dafür gelöscht.
            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');

            // Primärschlüssel, um doppelte Einträge (gleiches Bild für gleiche Familie) zu verhindern.
            $table->primary(['media_id', 'family_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_media');
    }
};
