<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempat', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->string('nicename', 25);
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->json('los');
            $table->integer('jml_los');
            $table->unsignedBigInteger('pengguna_id')->nullable();
            $table->foreign('pengguna_id')->references('id')->on('users');
            $table->unsignedBigInteger('pemilik_id')->nullable();
            $table->foreign('pemilik_id')->references('id')->on('users');
            $table->unsignedBigInteger('alat_listrik_id')->nullable();
            $table->foreign('alat_listrik_id')->references('id')->on('alat');
            $table->unsignedBigInteger('alat_airbersih_id')->nullable();
            $table->foreign('alat_airbersih_id')->references('id')->on('alat');
            $table->unsignedBigInteger('trf_listrik_id')->nullable();
            $table->foreign('trf_listrik_id')->references('id')->on('tarif');
            $table->unsignedBigInteger('trf_airbersih_id')->nullable();
            $table->foreign('trf_airbersih_id')->references('id')->on('tarif');
            $table->unsignedBigInteger('trf_keamananipk_id')->nullable();
            $table->foreign('trf_keamananipk_id')->references('id')->on('tarif');
            $table->unsignedBigInteger('trf_kebersihan_id')->nullable();
            $table->foreign('trf_kebersihan_id')->references('id')->on('tarif');
            $table->unsignedBigInteger('trf_airkotor_id')->nullable();
            $table->foreign('trf_airkotor_id')->references('id')->on('tarif');
            $table->json('trf_lainnya_id')->nullable();
            $table->json('diskon')->nullable();
            $table->text('ket')->nullable();
            $table->tinyInteger('status'); // 0 = Tidak Aktif, 1 = Aktif, 2 = Bebas Bayar
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
        Schema::dropIfExists('tempat');
    }
}
