<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebServiceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'web_service_id',
        'status_id',
    ];

    protected $hidden = [
        'web_service_id',
        'status_id',
    ];

    /**
     * Relation to the services
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(WebService::class);
    }

    /**
     * Relation to history status
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(HistoryStatus::class);
    }
}
