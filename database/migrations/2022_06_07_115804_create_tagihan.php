<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->unsignedBigInteger('periode_id');
            $table->foreign('periode_id')->references('id')->on('periode');
            $table->tinyInteger('stt_publish')->default(0); //0 = Belum Dipublish, 1 = Sudah Dipublish
            $table->tinyInteger('stt_lunas')->default(0); //0 = Belum Dilunaskan, 1 = Sudah Lunas
            $table->unsignedBigInteger('tempat_id');
            $table->foreign('tempat_id')->references('id')->on('tempat');
            $table->unsignedBigInteger('pengguna_id');
            $table->foreign('pengguna_id')->references('id')->on('users');
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->json('los');
            $table->integer('jml_los');
            $table->json('listrik')->nullable();
            $table->json('airbersih')->nullable();
            $table->json('keamananipk')->nullable();
            $table->json('kebersihan')->nullable();
            $table->json('airkotor')->nullable();
            $table->json('lainnya')->nullable();
            $table->json('tagihan');
            $table->tinyInteger('status')->default(1); //1 = Aktif, 0 = Deleted
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
        Schema::dropIfExists('tagihan');
    }
}
