<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();

            $table->foreignId('event_id')->constrained()->cascadeOnDelete();

            $table->string('certificate_number')->unique();

            $table->string('participant_name');

            $table->string('participant_email');

            $table->string('pdf_path')->nullable();

            $table->timestamp('generated_at')->nullable();

            $table->timestamp('sent_at')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};