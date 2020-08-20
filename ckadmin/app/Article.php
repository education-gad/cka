<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	//public $timestamps = false;
       protected $fillable = [
        'title', 'description',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

}
