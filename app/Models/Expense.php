<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'price',
        'amount',
        'total',
        'receipt_file_path',
        'note',
        'status',
        'user_id',
        'team_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Team
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Calculate total automatically
    public static function boot()
    {
        parent::boot();

        static::saving(function ($expense) {
            $expense->total = $expense->price * $expense->amount;
        });
    }
}