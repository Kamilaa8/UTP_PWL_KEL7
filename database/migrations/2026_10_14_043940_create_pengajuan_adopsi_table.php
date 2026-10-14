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
    Schema::create('pengajuan_adopsi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('pet_id')->constrained()->cascadeOnDelete();
        $table->text('alasan_adopsi');
        $table->string('status')->default('menunggu');
        $table->text('alasan_penolakan')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('pengajuan_adopsi');
}
};
