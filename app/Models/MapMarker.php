<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapMarker extends Model
{
    use HasFactory;
    const added_at = 'creation_date';
    const edited_at = 'updated_date';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
    ];

}
