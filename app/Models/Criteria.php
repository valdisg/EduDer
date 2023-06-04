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

    public function children()
    {
        return $this->belongsToMany(
            Criteria::class,
            'criteria_parent_child',
            'parent_id',
            'child_id'
        );
    }
}
