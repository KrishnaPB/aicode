<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('change_orders')) {
            Schema::create('change_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('estimate_id')->constrained('estimates')->cascadeOnDelete();
                $table->string('title');
                $table->text('description')->nullable();
                $table->decimal('amount', 12, 2);
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->timestamp('decided_at')->nullable();
                $table->timestamps();

                $table->index(['estimate_id', 'status']);
            });
        }
    }

    public function down(): void
    {
        // Drops the table only when this migration created it on a fresh schema.
        // On a database where change_orders already existed, the table is left in place.
        Schema::dropIfExists('change_orders');
    }
};
