<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('storage_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_code', 25)->unique();
            $table->foreignId('laundry_storage_id')->constrained('laundry_storages')->cascadeOnDelete();
            $table->foreignId('handled_by')->constrained('users')->restrictOnDelete();
            $table->string('ironer_name', 100)->nullable();
            $table->decimal('verified_weight', 8, 2)->default(0.00);
            $table->enum('action_type', ['masuk_rak', 'pindah_rak', 'serah_terima_ambil'])->default('masuk_rak');
            $table->timestamp('logged_at')->useCurrent();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('storage_logs');
    }
};
