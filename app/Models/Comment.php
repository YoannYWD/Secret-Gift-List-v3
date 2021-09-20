<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'gift_id'
    ];

    //Cardinalité
    public function users() {
        return $this->belongsToMany(User::class, 'comments', 'user_id', 'posted_by_user_id');
    }
    public function gifts() {
        return $this->belongsToMany(Gift::class, 'comments', 'gift_id', 'id');
    }
}

/*
https://apical.xyz/fiches/les_relations_avec_eloquent_orm_002/belongsToMany_pour_les_relations_0_vers_0

public function modelesB() : BelongsToMany

{

    return $this->belongsToMany('App\ModeleB', 'nom_table_pivot', 'nom_cle_etrangere_vers_table_actuelle', 'nom_cle_etrangere_vers_autre_table', 'nom_cle_primaire_dans_table_actuelle', 'nom_cle_primaire_dans_autre_table');

}

https://laravel.sillo.org/les-relations-avec-eloquent-12/
*/