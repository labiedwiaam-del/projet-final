<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->boolean('reminder_sent')->default(false)->after('notes');
            $table->unique(['medecin_id', 'date_rdv', 'heure_rdv'], 'no_double_booking');
        });
    }

    public function down(): void
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->dropUnique('no_double_booking');
            $table->dropColumn('reminder_sent');
        });
    }
};
