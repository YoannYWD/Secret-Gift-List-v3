<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'for_user_id',
        'posted_by_user_id'
    ];

    //Cardinalité
    public function user() {
        return $this->hasMany(User::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class, 'gifts', 'posted_by_user_id', 'gift_id');
    }
}
