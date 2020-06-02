<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->decimal('price',8,2);
            $table->enum('size', ['46','48','50','52'])->default('46');
            $table->text('url_image')->nullable();
            $table->enum('status', ['published', 'unpublished'])->default('unpublished');
            $table->enum('code', ['solde', 'new'])->default('new');
            $table->string('reference', 100);
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
        Schema::dropIfExists('products');
    }
}
