<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['userId', 'title', 'description'];
    const added_at = 'creation_date';
    const edited_at = 'updated_date';
    public $timestamps = false;
    protected $hidden = ['userId'];
    /**
     * Get all of the comments for the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /**
     * Get the user associated with the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    /**
     * Get all of the comments for the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
/**
 * Get all of the comments for the Blog
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'blogId');
    }
}
