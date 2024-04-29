<?php

namespace Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Company extends Model
{
    use HasFactory;
    use HasUuids;
    protected $keyType = 'string';
    protected $guarded = ['id'];

    /**
     * The users that belong to the company.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_companies');
    }

    /**
     * The projects that are associated with the company through users.
     */
    public function projects(): HasManyThrough
    {
        return $this->hasManyThrough(
            Project::class,
            UsersCompanies::class,
            'company_id',
            'user_company_id',
            'id',
            'id'
        );
    }
}
