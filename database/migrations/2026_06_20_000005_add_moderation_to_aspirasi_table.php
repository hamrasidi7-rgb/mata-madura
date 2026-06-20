<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspirasi', function (Blueprint $table) {
            $table->enum('moderation_status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('status');
            $table->timestamp('moderated_at')->nullable()->after('moderation_status');
            $table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete()->after('moderated_at');
            $table->string('rejection_reason')->nullable()->after('moderated_by');
        });

        // Data yang sudah ada & aktif → auto-approve agar tetap tampil di homepage
        DB::table('aspirasi')
            ->where('is_active', true)
            ->update([
                'moderation_status' => 'approved',
                'moderated_at'      => now(),
            ]);
    }

    public function down(): void
    {
        Schema::table('aspirasi', function (Blueprint $table) {
            $table->dropForeign(['moderated_by']);
            $table->dropColumn(['moderation_status', 'moderated_at', 'moderated_by', 'rejection_reason']);
        });
    }
};
