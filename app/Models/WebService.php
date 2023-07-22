<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
    ];

    /**
     * Relation to the history
     * @return HasMany
     */
    public function history(): HasMany
    {
        return $this->hasMany(WebServiceHistory::class)
            ->limit(10)
            ->orderBy('id', 'desc');
    }
}
