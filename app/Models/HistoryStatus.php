<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relation to web service history
     * @return BelongsTo
     */
    public function history(): BelongsTo
    {
        return $this->belongsTo(WebServiceHistory::class);
    }
}
