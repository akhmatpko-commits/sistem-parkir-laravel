
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('parking_transactions', 'parking_area_id')) {
            Schema::table('parking_transactions', function (Blueprint $table) {
                $table->foreignId('parking_area_id')
                    ->nullable()
                    ->constrained('parking_areas')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('parking_transactions', 'parking_area_id')) {
            Schema::table('parking_transactions', function (Blueprint $table) {
                $table->dropConstrainedForeignId('parking_area_id');
            });
        }
    }
};
