<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('phone', 15)->nullable();
            $table->string('member', 50)->unique()->nullable();
            $table->string('ktp', 20)->unique()->nullable();
            $table->string('npwp', 20)->unique()->nullable();
            $table->text('address')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger('level'); //1 = Super, 2 = Admin, 3 = Kasir, 4 = Keuangan, 5 = Manajer, 6 = Nasabah
            $table->json('otoritas')->nullable();
            $table->boolean('status')->default(1); //1 = Aktif, 0 = Nonaktif
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
        Schema::dropIfExists('users');
    }
}
