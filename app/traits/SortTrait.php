<?php
  
namespace traits;
use Post;

  
trait SortTrait 
{
  
    /**
     * @param Request $request
     * @return $this|false|string
     */

     
    public function sortabletrait($post,$limit) 
    {

        $sort_by =  \Input::get('sort_by')? : 'posts.id';
    	$sort_order = \Input::get('sort_order') ? : 'desc';
        $post = Post::orderBy($sort_by,$sort_order)->paginate($limit);
        return $post;
    }
  
} 