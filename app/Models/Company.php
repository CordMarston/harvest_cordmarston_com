<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'website'
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(CompanyLocation::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
