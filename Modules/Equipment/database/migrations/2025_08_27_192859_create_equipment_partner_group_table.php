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
        Schema::create('equipment_partner_group', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_group_id');
            $table->unsignedBigInteger('equipment_id');
            $table->boolean('is_provided')->default(false); 
            $table->timestamps();

            $table->foreign('partner_group_id')->references('id')->on('partner_groups')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_partner_group');
    }
};
