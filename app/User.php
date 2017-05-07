<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'email', 'FirstName','LastName',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'Birthday', 'created_at','updated_at'
    ];
}
