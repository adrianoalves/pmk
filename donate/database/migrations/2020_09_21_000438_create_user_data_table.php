<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataTable extends Migration
{
    public $table = 'user_data';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( $this->table, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger( 'id_user' )->unique();
            $table->json('store' )->nullable( false )->comment( 'additional user data in json format' );
            $table->timestamps();

            $table->foreign('id_user' )->references('id' )->on( 'user' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( $this->table );
    }
}
