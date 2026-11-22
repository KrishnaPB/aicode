<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('estimates')) {
            Schema::create('estimates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
                $table->string('number', 32);
                $table->uuid('public_uuid')->unique();
                $table->char('currency', 3)->default('USD');
                $table->decimal('total', 12, 2)->default(0);
                $table->enum('status', ['draft', 'sent', 'accepted', 'declined', 'expired'])->default('draft');
                $table->text('notes')->nullable();
                $table->timestamp('accepted_at')->nullable();
                $table->string('signature_name')->nullable();
                $table->string('signature_ip', 45)->nullable();
                $table->json('signature_meta')->nullable();
                $table->unsignedBigInteger('converted_invoice_id')->nullable(); // no foreign key by design
                $table->timestamps();

                $table->unique(['user_id', 'number']);
                $table->index(['user_id', 'status']);
            });
        }
    }

    public function down(): void
    {
        // Drops the table only when this migration created it on a fresh schema.
        // On a database where estimates already existed, the table is left in place.
        Schema::dropIfExists('estimates');
    }
};
