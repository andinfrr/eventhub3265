<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Organization;

class Transaction extends Model
{
    protected $fillable = [
    'organization_id',
    'event_id',
    'order_id',
    'customer_name',
    'customer_email',
    'customer_phone',
    'total_price',
    'status',
    'snap_token',
    ];

public function organization()
{
    return $this->belongsTo(Organization::class);
}

public function event()
{
    return $this->belongsTo(Event::class);
} 

}
