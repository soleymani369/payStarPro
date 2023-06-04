<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function commodities()
{
    return $this->hasManyThrough(Commodity::class, OrderCommodity::class);
}

public function items()
{
    return $this->hasMany(OrderCommodity::class);
}
public function transactions()
{
    return $this->hasMany(Transaction::class);
}
public function totalPrice()
{
    $sum = 0;
    foreach ($this->items as $item) {
        $sum += ($item->price *$item->count);
    }
    return $sum;
}
}
