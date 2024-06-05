<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressCustomer extends Model
{
    use HasFactory;

    public function User() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
