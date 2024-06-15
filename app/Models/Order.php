<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    const added_at = 'creation_date';
    public $timestamps = false;
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'order_sum'];
    /**
     * Get all of the OrderItems for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function id(): Attribute
    {return Attribute::make(
        get: fn(string $value) => ucfirst($value),
    );}
    public function OrderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

}
