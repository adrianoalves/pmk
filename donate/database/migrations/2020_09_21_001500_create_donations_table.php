<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    public $table = 'donation';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( $this->table, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user' )
                ->comment( 'donator id' );
            $table->unsignedTinyInteger('frequency' )->default(1)
                ->comment('1=unique,2=bimonthly,3=semiannual,4=yearly');
            $table->decimal('amount',10,2 )->nullable( false )
                ->comment('donation amount' );
            $table->timestamps();
            $table->unsignedTinyInteger('status' )->default( 1 );

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
