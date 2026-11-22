<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('workspace_members')) {
            Schema::create('workspace_members', function (Blueprint $table) {
                $table->id();
                $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
                $table->enum('role', ['owner', 'accountant_readonly']);
                $table->timestamps();

                $table->unique(['owner_id', 'member_id']);
                $table->index(['member_id', 'role']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('workspace_members');
    }
};
