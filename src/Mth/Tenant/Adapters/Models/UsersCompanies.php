<?php

namespace Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UsersCompanies extends Model
{
    use HasFactory;
    use HasUuids;

    protected $keyType = 'string';
    protected $guarded = ['id'];
    
    /**
     * Get the user associated with the pivot.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company associated with the pivot.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
