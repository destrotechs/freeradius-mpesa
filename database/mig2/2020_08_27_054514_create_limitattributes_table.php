<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimitattributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limitattributes', function (Blueprint $table) {
            $table->id();
            $table->string('vendor',200);
            $table->string('limitname',200);
            $table->string('type',200);
            $table->string('op',20);
            $table->string('table',50);
            $table->string('description',254);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('limitattributes');
    }
}
