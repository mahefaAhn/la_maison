<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table  ->foreignId('category_id') // respecter le type de la clé primaire de la table categories
                    ->nullable() // Un livre peut ne pas avoir de genre
                    ->constrained() 
                    ->onDelete('SET NULL'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // On supprime la contrainte
            $table->dropForeign('products_category_id_foreign');

            // Puis on supprime la colonne
            $table->dropColumn('category_id');
        });
    }
}
