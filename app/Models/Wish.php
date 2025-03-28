<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'price', 'url', 'book_user_id'];

    public function user(){
        return  $this->belongsTo(User::class);
    }
}
