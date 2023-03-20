<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'created_by_user_id',
        'name',
        'address',
        'age'
    ];

    public function createdByUserId()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function classRoom()
    {
        return $this->hasMany(ClassRoom::class);
    }
}
