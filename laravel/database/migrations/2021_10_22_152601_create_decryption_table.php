<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecryptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decryptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->string('key');
            $table->text('message');
            $table->string('cipherkey')->nullable();
            $table->text('ciphertext')->nullable();
            $table->string('private_key');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('encrypted_img')->nullable();
            $table->dateTime('upload_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('decryptions');
    }
}
