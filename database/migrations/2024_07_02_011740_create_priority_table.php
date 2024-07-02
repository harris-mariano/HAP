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
        Schema::create('priority', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('category');
        });

        DB::table('priority')->insert([
            ['id' => 1, 'category' => 'Required'],
            ['id' => 2, 'category' => 'New'],
            ['id' => 3, 'category' => 'In Progress'],
            ['id' => 4, 'category' => 'Solved'],
            ['id' => 5, 'category' => 'Closed'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priority');
    }
};
