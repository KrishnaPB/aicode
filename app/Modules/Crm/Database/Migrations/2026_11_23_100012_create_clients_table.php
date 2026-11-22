<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('clients')) {
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('name');
                $table->string('company_name')->nullable();
                $table->string('email')->nullable();
                $table->string('phone', 32)->nullable();
                $table->text('address')->nullable();
                $table->string('tax_id')->nullable();
                $table->char('currency', 3)->default('USD');
                $table->decimal('hourly_rate', 12, 2)->nullable();
                $table->string('portal_token', 64)->unique();
                $table->char('reliability_grade', 1)->nullable();
                $table->decimal('avg_days_to_pay', 6, 2)->nullable();
                $table->enum('status', ['active', 'archived'])->default('active');
                $table->timestamps();

                $table->index(['user_id', 'status']);
            });

            return;
        }

        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'user_id')) {
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('clients', 'name')) {
                $table->string('name');
            }
            if (!Schema::hasColumn('clients', 'company_name')) {
                $table->string('company_name')->nullable();
            }
            if (!Schema::hasColumn('clients', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('clients', 'phone')) {
                $table->string('phone', 32)->nullable();
            }
            if (!Schema::hasColumn('clients', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('clients', 'tax_id')) {
                $table->string('tax_id')->nullable();
            }
            if (!Schema::hasColumn('clients', 'currency')) {
                $table->char('currency', 3)->default('USD');
            }
            if (!Schema::hasColumn('clients', 'hourly_rate')) {
                $table->decimal('hourly_rate', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('clients', 'portal_token')) {
                $table->string('portal_token', 64)->unique();
            }
            if (!Schema::hasColumn('clients', 'reliability_grade')) {
                $table->char('reliability_grade', 1)->nullable();
            }
            if (!Schema::hasColumn('clients', 'avg_days_to_pay')) {
                $table->decimal('avg_days_to_pay', 6, 2)->nullable();
            }
            if (!Schema::hasColumn('clients', 'status')) {
                $table->enum('status', ['active', 'archived'])->default('active');
            }

            if (Schema::hasColumn('clients', 'portal_token') && !$this->hasIndexOn('clients', ['portal_token'], true)) {
                $table->unique('portal_token');
            }
            if (!$this->hasIndexOn('clients', ['user_id', 'status'])) {
                $table->index(['user_id', 'status']);
            }
        });
    }

    public function down(): void
    {
        // Intentionally a no-op: this table pre-exists with data; never drop it on rollback.
    }

    /**
     * Returns true when an index with exactly these columns exists on the table.
     */
    private function hasIndexOn(string $table, array $columns, bool $unique = false): bool
    {
        foreach (Schema::getIndexes($table) as $index) {
            if ($index['columns'] === $columns && (!$unique || $index['unique'])) {
                return true;
            }
        }

        return false;
    }
};
