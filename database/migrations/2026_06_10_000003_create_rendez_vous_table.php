<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('medecin_id')->constrained('medecins')->cascadeOnDelete();
            $table->date('date_rdv');
            $table->time('heure_rdv');
            $table->integer('duree');
            $table->enum('statut', ['programme', 'confirme', 'annule', 'termine'])->default('programme');
            $table->text('motif')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('date_creation')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
