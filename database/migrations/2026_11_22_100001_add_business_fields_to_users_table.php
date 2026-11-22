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
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_name')->nullable();
            $table->text('business_address')->nullable();
            $table->string('tax_id')->nullable();
            $table->char('default_currency', 3)->default('USD');
            $table->string('tax_registration_number')->nullable();
            $table->string('tax_label')->nullable();
            $table->decimal('default_tax_rate', 5, 2)->default(0);
            $table->unsignedTinyInteger('fiscal_year_start')->default(4);
            $table->string('invoice_prefix')->default('INV-');
            $table->unsignedInteger('next_invoice_number')->default(1001);
            $table->text('payment_instructions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'business_name',
                'business_address',
                'tax_id',
                'default_currency',
                'tax_registration_number',
                'tax_label',
                'default_tax_rate',
                'fiscal_year_start',
                'invoice_prefix',
                'next_invoice_number',
                'payment_instructions',
            ]);
        });
    }
};
