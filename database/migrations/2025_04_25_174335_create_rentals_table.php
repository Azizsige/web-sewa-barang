<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('rental_code')->unique();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->uuid('product_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_price');
            $table->enum('status', ['pending', 'ongoing', 'completed', 'canceled'])->default('pending');
            $table->string('proof_of_payment')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn([
                'rental_code',
                'customer_name',
                'customer_email',
                'customer_phone',
                'product_id',
                'start_date',
                'end_date',
                'total_price',
                'status',
                'proof_of_payment',
                'created_at',
                'updated_at'
            ]);
            $table->drop();
        });
    }
};
