<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLignecmdProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lignecmd_produit', function (Blueprint $table) {
             $table->increments('id');
            $table->integer('produit_id')->unsigned()->index();
            $table->foreign('produit_id')->references('id')->on('produits');
            $table->integer('lignecmd_id')->unsigned()->index();
            $table->foreign('lignecmd_id')->references('id')->on('lignecmds');
            $table->integer('quantity');
            $table->softDeletes();
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
        Schema::dropIfExists('lignecmd_produit');
    }
}
