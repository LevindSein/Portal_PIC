<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->tinyInteger('level'); //1 = Listrik, 2 = Air Bersih, 3 = Keamanan IPK, 4 = Kebersihan, 5 = Air Kotor, 6 = Lainnya
            $table->json('data');
            $table->tinyInteger('status')->default(1); //1 = per-Kontrol, 2 = per-Los
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
        Schema::dropIfExists('tarif');
    }
}
