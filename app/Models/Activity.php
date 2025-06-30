<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Activity as BaseActivity;

class Activity extends BaseActivity
{
    protected $appends = ['user_name'];

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'event',
        'session_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id', 'id');
    }

    protected function userName(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                //get attributes
                return User::where('id', $attributes['causer_id'])->pluck('name')->first();
            }
        );
    }
}
