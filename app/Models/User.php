<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail; // Add this import

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Add this method to use our custom verification email
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }

    /**
     * Relationships
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the user's profile photo URL.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path && file_exists(public_path($this->profile_photo_path))) {
            return asset($this->profile_photo_path);
        }
        
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&background=4900c7&color=fff";
    }
}