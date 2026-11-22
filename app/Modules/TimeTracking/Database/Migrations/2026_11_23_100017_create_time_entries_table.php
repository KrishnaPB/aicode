<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('time_entries')) {
            Schema::create('time_entries', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
                $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
                $table->string('description')->nullable();
                $table->timestamp('started_at');
                $table->timestamp('ended_at')->nullable();
                $table->unsignedInteger('duration_minutes')->default(0);
                $table->decimal('hourly_rate', 12, 2)->nullable();
                $table->boolean('is_billable')->default(true);
                $table->unsignedBigInteger('invoice_item_id')->nullable(); // no foreign key by design
                $table->timestamps();

                $table->index(['user_id', 'is_billable', 'invoice_item_id']);
                $table->index(['project_id', 'started_at']);
            });
        }
    }

    public function down(): void
    {
        // Drops the table only when this migration created it on a fresh schema.
        // On a database where time_entries already existed, the table is left in place.
        Schema::dropIfExists('time_entries');
    }
};
