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
    /*public function user() {
        return $this->belongsTo(User::class, 'gifts', 'id', 'posted_by_user_id');
    }*/
    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
