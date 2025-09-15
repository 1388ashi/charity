<?php
namespace Modules\Invoice\database\migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('virtual_gateways', function (Blueprint $table) {
           $table->id();
            if (config('invoice.float')) {
                $table->float('amount', 20, 2);
            } else {
                $table->unsignedBigInteger('amount');
            }
            $table->string('callback');
            $table->string('transaction_id');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('virtual_gateways');
    }

};
