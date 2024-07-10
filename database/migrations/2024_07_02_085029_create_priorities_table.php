<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('category');
        });

        DB::table('priorities')->insert([
            ['id' => 1, 'category' => 'Required'],
            ['id' => 2, 'category' => 'Low Priority'],
            ['id' => 3, 'category' => 'Medium Priority'],
            ['id' => 4, 'category' => 'High Priority'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priorities');
    }
};
