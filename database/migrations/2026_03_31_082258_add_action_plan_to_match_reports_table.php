<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('match_reports', function (Blueprint $table) {
            $table->text('action_plan')->nullable()->after('reasoning');
        });
    }

    public function down(): void
    {
        Schema::table('match_reports', function (Blueprint $table) {
            $table->dropColumn('action_plan');
        });
    }
};
