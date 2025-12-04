<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')
                    ->withTimestamps();
    }

    public function ownedTeams()
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Role Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    // Get first name
    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    // Scope for admins
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // Scope for students
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }
}