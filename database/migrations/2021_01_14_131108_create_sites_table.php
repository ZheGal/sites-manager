<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->integer('user_id');
            $table->integer('campaign_id');
            $table->integer('hoster_id');
            $table->integer('hoster_id_domain');
            $table->string('ftp_host');
            $table->string('ftp_user');
            $table->string('ftp_pass');
            $table->integer('yandex');
            $table->integer('facebook');
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
        Schema::dropIfExists('sites');
    }
}
