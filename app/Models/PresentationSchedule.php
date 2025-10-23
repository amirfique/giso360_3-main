<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'presentation_date',
        'presentation_time',
        'location',
        'notes'
    ];

    protected $casts = [
        'presentation_date' => 'date',
        'presentation_time' => 'datetime:H:i',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with Team
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}