<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'rate',
        'content',
        'user_id',
        'product_id'
    ];

    public function images(){
        return $this -> belongsToMany(ReviewImage::class);
    }
}
