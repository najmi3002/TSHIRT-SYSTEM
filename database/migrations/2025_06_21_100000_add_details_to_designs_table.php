<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->decimal('deposit', 8, 2)->nullable()->after('total_price');
            $table->decimal('fullpayment', 8, 2)->nullable()->after('deposit');
            $table->string('status')->default('pending')->after('fullpayment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn(['deposit', 'fullpayment', 'status']);
        });
    }
}; 