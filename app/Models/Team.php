<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'planned_budget', 
        'slug',
        'join_code',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'team_user')
                    ->withPivot('role')  // Added this line to include role from pivot table
                    ->withTimestamps();
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

    public function presentationSchedule()
    {
        return $this->hasOne(PresentationSchedule::class);
    }
}