
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parkirs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_parkir')->unique();
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('kendaraan_id')
                ->constrained('kendaraans')
                ->restrictOnDelete();

            $table->foreignId('tarif_id')
                ->constrained('tarifs')
                ->restrictOnDelete();

            $table->string('nomor_polisi', 20)->index();
            $table->string('nama_pemilik')->nullable();
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable();
            $table->unsignedInteger('durasi_jam')->nullable();
            $table->decimal('total_biaya', 12, 2)->default(0);
            $table->enum('status', ['masuk', 'keluar'])
                ->default('masuk');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parkirs');
    }
};
