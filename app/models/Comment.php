<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Comment extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comments';

    protected $fillable = [ 'post_id', 'comments'];

	protected $hidden = ['created_at','updated_at'];

   public function post()
   {
	   return $this->belongsTo(Post::class);
   }	
   public function replies()
    {
        return $this->hasMany(Comment::class,'parent_id');
    }

	public function parent()
	{
		return $this->belongsTo(Comment::class,'parent_id');
	}	
	

	// /**
	//  * The attributes excluded from the model's JSON form.
	//  *
	//  * @var array
	//  */
	// protected $hidden = array('password', 'remember_token');


}
