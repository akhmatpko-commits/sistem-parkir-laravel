
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parkir_id')
                ->unique()
                ->constrained('parkirs')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->decimal('jumlah_bayar', 12, 2);
            $table->decimal('uang_diterima', 12, 2);
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->enum('metode', ['tunai', 'non_tunai'])
                ->default('tunai');

            $table->dateTime('tanggal_bayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
