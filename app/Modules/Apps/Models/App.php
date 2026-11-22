<?php

namespace App\Modules\Apps\Models;

use App\Models\User;
use App\Modules\Apps\Database\Factories\AppFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'name', 'description'])]
final class App extends Model
{
    /** @use HasFactory<AppFactory> */
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return AppFactory::new();
    }

    /**
     * Get the user that owns the app.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
