<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL: modificare ENUM esistenti
        DB::statement("ALTER TABLE policies MODIFY type ENUM('auto', 'home', 'life', 'health') NOT NULL");
        DB::statement("ALTER TABLE policies MODIFY status ENUM('active', 'expired', 'cancelled', 'pending') DEFAULT 'active'");
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('policies', function (Blueprint $table) {
            // Ripristino valori originali
            DB::statement("ALTER TABLE policies MODIFY type ENUM('auto', 'home', 'life') NOT NULL");
            DB::statement("ALTER TABLE policies MODIFY status ENUM('active', 'expired', 'cancelled') DEFAULT 'active'");
        });
    }
};
