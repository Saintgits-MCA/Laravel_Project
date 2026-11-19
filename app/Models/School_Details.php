<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School_Details extends Model
{
    use HasFactory;

    protected $table = 'school_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'school_name',
        'school_code',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
        'status',
    ];
}