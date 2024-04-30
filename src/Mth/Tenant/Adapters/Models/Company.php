<?php

namespace Mth\Tenant\Adapters\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mth\Tenant\Core\Constants\ColumnNames\ProjectColumns;

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
     * The projects associated with the company.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, ProjectColumns::COMPANY_ID);
    }
}
