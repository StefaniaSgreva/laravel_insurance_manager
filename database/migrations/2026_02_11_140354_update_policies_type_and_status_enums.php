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
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite: non può avere ENUM, usa stringa normale
            Schema::table('policies', function (Blueprint $table) {
                // Se la colonna esiste già e devi modificarne il tipo:
                $table->string('type', 20)->default('auto')->change();
            });
        } else {
            // MySQL / PostgreSQL / ... : ENUM come da progetto
            Schema::table('policies', function (Blueprint $table) {
                $table->enum('type', ['auto', 'home', 'life', 'health'])
                    ->default('auto')
                    ->change();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            Schema::table('policies', function (Blueprint $table) {
                $table->string('type', 20)->default('auto')->change();
            });
        } else {
            // Ripristina a stringa o come era prima
            Schema::table('policies', function (Blueprint $table) {
                $table->string('type', 20)->default('auto')->change();
            });
        }
    }
};
