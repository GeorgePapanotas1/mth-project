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
     * Get the users_companies pivot that the project belongs to.
     */
    public function usersCompany(): BelongsTo
    {
        return $this->belongsTo(UsersCompanies::class, 'user_company_id');
    }

    /**
     * Get the user that is associated with the project.
     */
    public function user(): BelongsTo
    {
        return $this->usersCompany->user();
    }

    /**
     * Get the company that is associated with the project.
     */
    public function company(): BelongsTo
    {
        return $this->usersCompany->company();
    }
}
