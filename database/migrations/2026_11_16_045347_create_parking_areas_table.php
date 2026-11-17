<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parking_areas', function (Blueprint $table) {
            $table->id();
            $table->string('area_code')->unique();
            $table->string('area_name');
            $table->enum('vehicle_type', ['Motor', 'Mobil', 'Semua']);
            $table->integer('capacity')->default(0);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parking_areas');
    }
};