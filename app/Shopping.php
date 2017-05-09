<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'idUser', 'idProduct','Price','created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *AC
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];
}
