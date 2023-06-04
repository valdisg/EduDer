<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public const SCHOOL_TYPE_GENERAL_SECONDARY_SCHOOL = 6;
    public const SCHOOL_TYPE_STATE_HIGH_SCHOOL = 9;

    public const  SCHOOL_TYPES = [
        self::SCHOOL_TYPE_GENERAL_SECONDARY_SCHOOL => 'Vispārizglītojošā vidusskola',
        self::SCHOOL_TYPE_STATE_HIGH_SCHOOL => 'Valsts ģimnāzija',
    ];

    use HasFactory;

    protected $fillable = [
        'school_title',
        'address',
        'type',
        'type_name',
        'school_data_id',
        'coordinates',
        'registration_number',
        'phone_number',
        'email',
        'url',
        'image',
        'manager',
    ];

    public function criteria()
    {
        return $this->belongsToMany(Criteria::class, 'criteria_schools', 'school_id', 'criteria_id');
    }
}
