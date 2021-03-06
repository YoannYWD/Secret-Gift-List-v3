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

    protected $with = ['user'];

    //Cardinalité
    public function user() {
        return $this->belongsTo(User::class, 'user_id'); //préciser la colonne concernée
    }
    public function gift() {
        return $this->belongsTo(Gift::class, 'gift_id');
    }
}

/*
https://apical.xyz/fiches/les_relations_avec_eloquent_orm_002/belongsToMany_pour_les_relations_0_vers_0

public function modelesB() : BelongsToMany

{

    return $this->belongsToMany('App\ModeleB', 'nom_table_pivot', 'nom_cle_etrangere_vers_table_actuelle', 'nom_cle_etrangere_vers_autre_table', 'nom_cle_primaire_dans_table_actuelle', 'nom_cle_primaire_dans_autre_table');

}

https://laravel.sillo.org/les-relations-avec-eloquent-12/

https://laracasts.com/discuss/channels/eloquent/trying-to-get-a-post-with-comments-and-user-name
*/