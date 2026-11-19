<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Optional - Laravel automatically assumes 'students')
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     * This is required if you plan to create or update students using forms.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'age',
        'email',
        'phone',
        'course',
        'status',
        'address',
    ];

    /**
     * The attributes that should be cast.
     * Helps format data automatically (e.g., dates).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        // 'dob' => 'date', // Uncomment if you have a date of birth column
    ];
}
