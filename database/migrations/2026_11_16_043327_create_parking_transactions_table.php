
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parking_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique();
            $table->string('plate_number');
            $table->enum('vehicle_type', ['Motor', 'Mobil']);
            $table->dateTime('entry_time');
            $table->dateTime('exit_time')->nullable();
            $table->decimal('parking_fee', 12, 2)->default(0);
            $table->enum('status', ['masuk', 'keluar'])->default('masuk');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parking_transactions');
    }
};
