<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commodity extends Model
{
    use HasFactory;
    public const STORAGE_DIR = 'C:/Users/ahmad/Desktop/payStar/public/static/commodity';
    protected $fillable =['name' , 'price' ,'amount' , 'body'];


    public function orderCommodities()
    {
        return $this->hasMany(OrderCommodity::class);
    }
    public function orders()
    {
        return $this->hasManyThrough(Order::class, OrderCommodity::class);
    }
        public function purge(): void
        {
            if ($this->image) {
                $fp= sprintf('%s/%s', self::STORAGE_DIR, $this->image);
                if (file_exists($fp)) {
                    unlink($fp);
                }
            }
            $this->delete();
        }
}
