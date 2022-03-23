<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id('template_id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('img_src')->default('');
            $table->string('description')->default('');
            $table->timestamps();
            $table->softDeletes();
        });

        try {
            DB::table('templates')->insert([
                'name'        => 'custom',
                'slug'        => 'custom',
                'description' => 'Use your own custom template',
                'img_src'     => 'https://picsum.photos/200/200/?image=25',
            ]);
            dump('Inserted Default Custom Template.');
        } catch (\Exception $e) {
            dump('Could not create custom template.', $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('templates');
    }
}
