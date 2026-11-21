<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('racks', function (Blueprint $table) {
            $table->id();
            $table->string('rack_code', 20)->unique();
            $table->string('cabinet_number', 20);
            $table->string('column_number', 20);
            $table->decimal('max_capacity_kg', 8, 2)->default(50.00);
            $table->decimal('current_load_kg', 8, 2)->default(0.00);
            $table->enum('status', ['tersedia', 'penuh', 'perbaikan'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('racks');
    }
};
