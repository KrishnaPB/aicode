<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
                $table->string('title');
                $table->enum('billing_type', ['fixed', 'hourly', 'retainer']);
                $table->decimal('rate', 12, 2)->nullable();
                $table->enum('status', ['active', 'paused', 'completed'])->default('active');
                $table->timestamps();

                $table->index(['user_id', 'client_id']);
            });

            return;
        }

        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'client_id')) {
                $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('projects', 'billing_type')) {
                $table->enum('billing_type', ['fixed', 'hourly', 'retainer']);
            }
            if (!Schema::hasColumn('projects', 'rate')) {
                $table->decimal('rate', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('projects', 'status')) {
                $table->enum('status', ['active', 'paused', 'completed'])->default('active');
            }
        });
    }

    public function down(): void
    {
        // Intentionally a no-op: this table pre-exists with data; never drop it on rollback.
    }
};
