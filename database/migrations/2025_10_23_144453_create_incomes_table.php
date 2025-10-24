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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('income_id')->nullable();
            $table->string('number')->nullable();
            $table->string('date')->nullable();
            $table->string('last_change_date')->nullable();
            $table->string('supplier_article')->nullable();
            $table->string('tech_size')->nullable();
            $table->integer('barcode')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('total_price')->nullable();
            $table->string('date_close')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->integer('nm_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
