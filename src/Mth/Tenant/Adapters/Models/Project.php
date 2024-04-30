<?php

namespace Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;
    use HasUuids;

    protected $keyType = 'string';
    protected $guarded = ['id'];

    /**
     * Get the user that is associated with the project.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company that is associated with the project.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
