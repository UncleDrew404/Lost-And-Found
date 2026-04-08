<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'phone_number',
        'bio',
        'avatar',
        'department',
        'student_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
