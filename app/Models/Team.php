<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_team');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'team_permission');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user');
    }
}
