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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->nullable()->constrained()->nullOnDelete();

            $table->string('full_name');
            $table->string('identity_number')->nullable()->index();
            $table->date('birth_date')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->text('address')->nullable();
            $table->string('city_zone')->nullable();

            $table->string('primary_phone')->nullable()->index();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('reference_name')->nullable();
            $table->string('reference_phone')->nullable();
            $table->string('reference_relationship')->nullable();

            $table->date('application_date')->nullable()->index();
            $table->string('work_modality')->nullable();
            $table->string('availability_schedule')->nullable();
            $table->boolean('availability_immediate')->default(false)->index();
            $table->decimal('salary_expectation', 10, 2)->nullable();
            $table->string('vacancy_source')->nullable();
            $table->boolean('has_experience')->default(false);
            $table->decimal('experience_years', 4, 1)->nullable();
            $table->text('experience_summary')->nullable();
            $table->string('education_level')->nullable();
            $table->string('educational_institution')->nullable();
            $table->text('courses_certifications')->nullable();
            $table->text('main_skills')->nullable();
            $table->string('portfolio_link')->nullable();

            $table->string('status')->default('Nuevo')->index();
            $table->unsignedTinyInteger('overall_rating')->nullable()->index();
            $table->text('strengths')->nullable();
            $table->text('weaknesses')->nullable();
            $table->text('internal_notes')->nullable();
            $table->boolean('recommended')->nullable();
            $table->dateTime('last_interview_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
