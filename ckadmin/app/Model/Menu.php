<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
	protected $fillable = [

		'name',

		'order',

		'visible',

	];

	protected $primaryKey = 'id';

	protected $table = 'menus';

	public $timestamps = false;
}
