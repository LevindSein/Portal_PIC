<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periode', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->unique();
            $table->string('nicename', 20);
            $table->date('new');
            $table->date('due');
            $table->string('year', 4);
            $table->integer('faktur')->default(1);
            $table->integer('surat')->default(1);
            $table->tinyInteger('status')->default(1); // 1 = Open, 0 = Tutup Buku
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
        Schema::dropIfExists('periode');
    }
}
