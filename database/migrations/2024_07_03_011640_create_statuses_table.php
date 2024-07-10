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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->timestamps();
        });

        DB::table('statuses')->insert([
            ['id' => 1, 'category' => 'New'],
            ['id' => 2, 'category' => 'In Progress'],
            ['id' => 3, 'category' => 'Resolved'],
            ['id' => 4, 'category' => 'Closed']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
