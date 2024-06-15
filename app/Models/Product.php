<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const added_at = 'creation_date';
    const edited_at = 'updated_date';
    public $timestamps = false;
    use HasFactory;
}
