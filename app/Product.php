<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'Name', 'Type', 'idStore', 'idPrice'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at'
    ];
}
