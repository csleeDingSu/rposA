<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
   
    public function parent() {
		return $this->belongsTo('App\Category', 'parent_id');
	}

	public function children() {
		return $this->hasMany('App\Category', 'parent_id'); //get all subs. NOT RECURSIVE
	}
	
}