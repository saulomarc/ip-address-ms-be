<?php

namespace App\Models;

use App\Observers\IpAddressObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy([IpAddressObserver::class])]
class IpAddress extends Model
{
    protected $appends = ['owner_name'];

    protected $fillable = [
        'ip_address',
        'label',
        'comment',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function logs(): MorphMany
    {
        return $this->MorphMany(Activity::class, 'subject');
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

        if ($filters->has('owner_name_like') && $filters->owner_name_like != '' && $filters->owner_name_like != '--') {
            $query->whereRelation('user', 'name', 'ILIKE', '%' . $filters->owner_name_like . '%');
        }

        if ($filters->has('ip_address_like') && $filters->ip_address_like != '' && $filters->ip_address_like != '--') {
            $query->where('ip_address', 'ILIKE', '%' . $filters->ip_address_like . '%');
        }

        if ($filters->has('label_like') && $filters->label_like != '' && $filters->label_like != '--') {
            $query->where('label', 'ILIKE', '%' . $filters->label_like . '%');
        }
    }

    public function scopeWithLogs($query)
    {
        $query->with('logs');
    }

    protected function ownerName(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                //get attributes
                return User::where('id', $attributes['user_id'])->pluck('name')->first();
            }
        );
    }
}
