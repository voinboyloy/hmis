<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffProfile extends Model
{
    use HasFactory;
    protected $guarded = []; // Allow mass assignment

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
