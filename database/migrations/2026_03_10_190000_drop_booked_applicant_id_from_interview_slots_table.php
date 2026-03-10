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
        if (!Schema::hasColumn('interview_slots', 'booked_applicant_id')) {
            return;
        }

        Schema::table('interview_slots', function (Blueprint $table) {
            $table->dropConstrainedForeignId('booked_applicant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('interview_slots', 'booked_applicant_id')) {
            return;
        }

        Schema::table('interview_slots', function (Blueprint $table) {
            $table->foreignId('booked_applicant_id')->nullable()->constrained('applicants')->nullOnDelete();
        });
    }
};
