<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','meta','currency_id',
    ];
	
	/**
     * Cast meta property to array
     *
     * @var object
     */
	 
	protected $casts = [
        'meta' => 'object',
    ];
	
	/**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'currency_id'
    ];
	
	function currency(){
		return $this->belongsTo('App\Currency');
	}
}
