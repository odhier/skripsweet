<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncryptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encryptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->string('key');
            $table->text('message');
            $table->string('cipherkey')->nullable();
            $table->text('ciphertext')->nullable();
            $table->integer('p');
            $table->integer('q');
            $table->bigInteger('k');
            $table->string('factor_k');
            $table->string('public_key');
            $table->string('private_key');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encryptions');
    }
}
