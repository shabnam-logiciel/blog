<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Post extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

	// protected $fillabe = ['title','description'];
  
	public $primarykey = 'id';
  

    public $timestamps = 'true';



	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	
	public function user()
	{
	  return $this->belongsTo(User::class,'user_id','id');
	}
	
	


	
     

	// /**
	//  * The attributes excluded from the model's JSON form.
	//  *
	//  * @var array
	//  */
	// protected $hidden = array('password', 'remember_token');

}