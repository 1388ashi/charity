<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile', 50)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
        \DB::table('admins')->insert([
            'name' => 'ادمین کل',
            'mobile' => '09334496439',
            'password' => bcrypt('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
