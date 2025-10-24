<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('date')->nullable();
            $table->string('last_change_date')->nullable();
            $table->string('supplier_article')->nullable();
            $table->string('tech_size')->nullable();
            $table->integer('barcode')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('is_supply')->nullable();
            $table->boolean('is_realization')->nullable();
            $table->integer('quantity_full')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->integer('in_way_to_client')->nullable();
            $table->integer('in_way_from_client')->nullable();
            $table->integer('nm_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->integer('sc_code')->nullable();
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
