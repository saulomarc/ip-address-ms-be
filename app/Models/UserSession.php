<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSession extends Model
{
    protected $appends = ['user_name'];

    protected $fillable = [
        'user_id',
        'session_id',
        'logged_on',
        'logged_out'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(Activity::class, 'session_id', 'session_id');
    }

    public function scopeFilter($query, $filters, $role = null)
    {
        //select fields
        if ($filters->has('fields')) {
            foreach ($filters->fields as $key => $value) {
                $newField = $value;

                if ($key === 0) {
                    $query = $query->select($newField);
                } else {
                    $query = $query->addSelect($newField);
                }
            }
        }

        //order
        if ($filters->has('order_type')) {
            $query->orderBy($filters->order_field, $filters->order_type);
        }

        //distinct
        if ($filters->has('distinct')) {
            $query->select($filters->column_name)->distinct();
        }
    }

    public function scopeWithLogs($query)
    {
        $query->with('logs');
    }

    protected function userName(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                //get attributes
                return User::where('id', $attributes['user_id'])->pluck('name')->first();
            }
        );
    }
}
