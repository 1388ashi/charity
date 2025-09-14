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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_group_id')->constrained('partner_groups')->onDelete('cascade');
            $table->enum('gender', ['male', 'female']);
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->string('national_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('address');
            $table->string('job'); 
            $table->enum('education', [
                'cycle',        // سیکل
                'diploma',      // دیپلم
                'associate',    // فوق دیپلم
                'bachelor',     // لیسانس
                'master',       // فوق لیسانس
                'doctorate'     // دکتری
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
