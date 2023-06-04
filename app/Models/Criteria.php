<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = [
    ];


    public function school()
    {
        return $this->belongsToMany(School::class, 'criteria_schools', 'criteria_id', 'school_id');
    }
}
