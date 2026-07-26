<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->tinyInteger('rating');

            $table->text('review')->nullable();

            $table->timestamps();

            // satu user hanya boleh rating sekali per event
            $table->unique(['user_id','event_id']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};