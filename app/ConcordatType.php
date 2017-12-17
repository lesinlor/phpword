<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConcordatType extends Model
{
    protected $table = 'concordat_type';

    protected $hidden = [
        'created_at','updated_at','created_user_id','updated_user_id'
    ];

}
