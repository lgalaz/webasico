<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id('website_id');
            $table->bigInteger('account_id')->unsigned();
            $table->bigInteger('template_id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();

            $table->unique(['name', 'account_id']);
            $table->unique(['slug', 'account_id']);

            $table->foreign('account_id')
                ->references('account_id')
                ->on('accounts')
                ->onDelete('cascade');

            $table->foreign('template_id')
                ->references('template_id')
                ->on('templates')
                ->onDelete('cascade');

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
        Schema::dropIfExists('websites');
    }
}
