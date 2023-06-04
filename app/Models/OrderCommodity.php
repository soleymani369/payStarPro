<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCommodity extends Model
{
    use HasFactory;
    protected $fillable = ['order_id' , 'commodity_id' , 'price'  ,'count'];

    public function odrer()
    {
        return $this->belongsTo(Order::class);
    }

    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }
}
