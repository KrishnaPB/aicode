<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('estimate_items')) {
            Schema::create('estimate_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('estimate_id')->constrained('estimates')->cascadeOnDelete();
                $table->string('description');
                $table->decimal('quantity', 10, 2)->default(1);
                $table->decimal('unit_price', 12, 2);
                $table->decimal('amount', 12, 2);
                $table->boolean('is_optional')->default(false);
                $table->unsignedInteger('position')->default(0);
                $table->timestamps();

                $table->index(['estimate_id', 'is_optional']);
            });
        }
    }

    public function down(): void
    {
        // Drops the table only when this migration created it on a fresh schema.
        // On a database where estimate_items already existed, the table is left in place.
        Schema::dropIfExists('estimate_items');
    }
};
