
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parking_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parking_transaction_id')
                ->unique()
                ->constrained('parking_transactions')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->decimal('amount', 12, 2);
            $table->decimal('amount_received', 12, 2);
            $table->decimal('change_amount', 12, 2)->default(0);

            $table->enum('method', ['tunai', 'non_tunai'])
                ->default('tunai');

            $table->dateTime('paid_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parking_payments');
    }
};
