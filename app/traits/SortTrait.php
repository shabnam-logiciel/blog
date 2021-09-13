<?php
  
namespace traits;
use Post;

  
trait SortTrait {
  
    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function sortabletrait($rule,$limit) {

        $sort_by =  \Input::get('sort_by')? : 'post.id';
    	$sort_order = \Input::get('sort_order') ? : 'desc';
        $rule = Post::orderBy($sort_by,$sort_order)->paginate($limit);
        return $rule;
    }
  
}