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
            $table->renameColumn('collar', 'collar_type');
            $table->renameColumn('fabric', 'fabric_type');
            $table->renameColumn('sleeve', 'sleeve_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->renameColumn('collar_type', 'collar');
            $table->renameColumn('fabric_type', 'fabric');
            $table->renameColumn('sleeve_type', 'sleeve');
        });
    }
};
