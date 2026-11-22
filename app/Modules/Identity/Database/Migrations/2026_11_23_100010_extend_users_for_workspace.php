<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'business_name')) {
                $table->string('business_name', 255)->nullable();
            }
            if (!Schema::hasColumn('users', 'business_address')) {
                $table->text('business_address')->nullable();
            }
            if (!Schema::hasColumn('users', 'tax_id')) {
                $table->string('tax_id', 64)->nullable();
            }
            if (!Schema::hasColumn('users', 'tax_label')) {
                $table->string('tax_label', 32)->nullable();
            }
            if (!Schema::hasColumn('users', 'default_tax_rate')) {
                $table->decimal('default_tax_rate', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('users', 'default_currency')) {
                $table->char('default_currency', 3)->default('USD');
            }
            if (!Schema::hasColumn('users', 'fiscal_year_start')) {
                $table->unsignedTinyInteger('fiscal_year_start')->default(1);
            }
            if (!Schema::hasColumn('users', 'tax_reserve_percent')) {
                $table->decimal('tax_reserve_percent', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('users', 'invoice_prefix')) {
                $table->string('invoice_prefix', 16)->default('INV-');
            }
            if (!Schema::hasColumn('users', 'next_invoice_number')) {
                $table->unsignedInteger('next_invoice_number')->default(1);
            }
            if (!Schema::hasColumn('users', 'payment_instructions')) {
                $table->text('payment_instructions')->nullable();
            }
            if (!Schema::hasColumn('users', 'brand_color')) {
                $table->string('brand_color', 7)->nullable();
            }
            if (!Schema::hasColumn('users', 'logo_path')) {
                $table->string('logo_path', 255)->nullable();
            }
            if (!Schema::hasColumn('users', 'custom_domain')) {
                $table->string('custom_domain', 255)->nullable()->unique();
            }
            if (!Schema::hasColumn('users', 'inbound_expense_alias')) {
                $table->string('inbound_expense_alias', 64)->nullable()->unique();
            }
        });
    }

    public function down(): void
    {
        // No-op: these columns were added to an existing table.
    }
};
