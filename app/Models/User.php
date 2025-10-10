<?php

namespace App\Models;

use Filament\Panel;
use App\Models\StaffProfile;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'patient_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true; // Or add your own logic, e.g., str_ends_with($this->email, '@yourdomain.com')
    }
     public function staffProfile(): HasOne
    {
        return $this->hasOne(StaffProfile::class);
    }
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
   public function getFilamentAvatarUrl(): ?string
{
    $path = $this->staffProfile?->profile_photo_path;

    if ($path && Storage::disk('public')->exists($path)) {
        // Use the asset helper as an alternative
        return asset('storage/' . $path);
    }
    return null;
}
}
