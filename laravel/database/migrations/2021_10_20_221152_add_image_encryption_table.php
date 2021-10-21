<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageEncryptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('encryptions', function (Blueprint $table) {
            $table->text('original_img')->nullable();
            $table->text('encrypted_img')->nullable();
            $table->dateTime('upload_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('encryptions', function (Blueprint $table) {
            //
        });
    }
}
