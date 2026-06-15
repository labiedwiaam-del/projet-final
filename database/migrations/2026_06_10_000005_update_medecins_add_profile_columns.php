<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medecins', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('specialite');
            $table->string('photo', 255)->nullable()->after('bio');
            $table->boolean('is_active')->default(true)->after('photo');
        });
    }

    public function down(): void
    {
        Schema::table('medecins', function (Blueprint $table) {
            $table->dropColumn(['bio', 'photo', 'is_active']);
        });
    }
};
