<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index()->unique();
            $table->string('password');
            $table->string('machine_code')->unique();
            $table->string('name');
            $table->string('surname');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('license_type', ['demo', 'registered'])->default('demo')->index();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licenses');
    }
}
