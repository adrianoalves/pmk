<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTable extends Migration
{
    public $table = 'payment_method_credit';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( $this->table, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user' )->comment( 'donator payment method owner' );
            $table->string( 'name_on_card' )->comment('user name on card' );
            $table->string( 'card_number' )->comment('card identifier' );
            $table->unsignedTinyInteger( 'expire_at_month' )->comment('expiration month' );
            $table->unsignedTinyInteger( 'expire_at_year' )->comment('expiration year' );
            $table->timestamps();
            $table->unsignedTinyInteger('status' )->default(1);

            $table->foreign('id_user' )->references('id')->on('user' );
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
