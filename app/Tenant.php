<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','meta','username'
    ];
	
	/**
     * Cast meta property to array
     *
     * @var object
     */
	 
	protected $casts = [
        'meta' => 'object',
    ];
}
