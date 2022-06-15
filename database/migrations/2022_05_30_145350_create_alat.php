<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alat', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 50)->unique();
            $table->tinyInteger('level'); // 1 = Listrik, 2 = Air Bersih
            $table->integer('stand');
            $table->integer('stand_old')->nullable();
            $table->integer('daya')->nullable();
            $table->boolean('status')->default(1); // 1 = Tersedia, 0 = Digunakan
            $table->datetime('updated_at')->useCurrent();
            $table->datetime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alat');
    }
}
