<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laundry_storages', function (Blueprint $table) {
            $table->id();
            $table->string('storage_code', 25)->unique();
            $table->foreignId('rack_id')->constrained('racks')->restrictOnDelete();
            $table->foreignId('service_category_id')->constrained('service_categories')->restrictOnDelete();
            $table->foreignId('staff_id')->constrained('users')->restrictOnDelete();
            $table->string('customer_name', 100);
            $table->string('customer_phone', 20)->index();
            $table->decimal('laundry_weight', 8, 2);
            $table->boolean('include_delivery')->default(false);
            $table->decimal('total_price', 12, 2);
            $table->enum('payment_status', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->enum('storage_status', ['tersimpan', 'siap_diambil', 'selesai'])->default('tersimpan');
            $table->timestamp('stored_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laundry_storages');
    }
};
