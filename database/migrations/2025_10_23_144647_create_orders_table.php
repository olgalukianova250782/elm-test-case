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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('g_number')->nullable();
            $table->string('date')->nullable();
            $table->string('last_change_date')->nullable();
            $table->string('supplier_article')->nullable();
            $table->string('tech_size')->nullable();
            $table->integer('barcode')->nullable();
            $table->string('total_price')->nullable();
            $table->integer('discount_percent')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->string('oblast')->nullable();
            $table->integer('income_id')->nullable();
            $table->string('odid')->nullable();
            $table->integer('nm_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->boolean('is_cancel')->nullable();
            $table->string('cancel_dt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
