<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;



class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'price', 'quantity', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

}
