<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoGraph extends Model
{
    protected $fillable = [
        'title', 'description',
    ];

    public function user() {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
