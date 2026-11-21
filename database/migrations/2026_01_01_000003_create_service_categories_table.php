<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_code', 20)->unique();
            $table->enum('service_type', ['kiloan_reguler', 'kiloan_express', 'satuan', 'tambahan']);
            $table->string('service_name', 100);
            $table->string('unit_label', 20)->default('Kg');
            $table->decimal('price', 10, 2);
            $table->decimal('min_weight_kg', 5, 2)->default(0.00);
            $table->unsignedInteger('estimated_hours')->default(48);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
