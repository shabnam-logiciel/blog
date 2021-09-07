<?php
namespace transformer;
use User;
use League\Fractal\TransformerAbstract;
class UserTransformer extends TransformerAbstract
{
    // protected $availableIncludes = [
    //     'comment'
    // ];
    public function transform($user)
    {
        return [
            'id'            => $user->id,
            'first_name'         =>  $user->first_name,
            'last_name'         =>  $user->last_name,
            'email'   =>  $user->email,
            'active'   =>  $user->active,
            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $user->updated_at->format('Y-m-d H:i:s')
         ];
    }
    // public function includeComment($post)
    // {
    //     $comment = $post->comment;
    //     if($comment){
    //     return $this->collection($comment, new CommentTransformer);
    //     }
    // }
}