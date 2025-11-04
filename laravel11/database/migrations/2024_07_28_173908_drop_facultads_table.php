<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFacultadsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('facultads');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('facultads', function (Blueprint $table) {
          
        });
    }
};
