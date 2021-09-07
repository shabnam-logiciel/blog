<?php
  
namespace transformer;
use Post;
use League\Fractal\TransformerAbstract;


class PostTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'comments','users'
    ];


    public function transform($add)
    {
     
        return [
            'id'            => (int) $add->id,
            'user_id'      =>$add->user_id,
            'title'         => $add->title,
            'description'   => $add->description,
            'created_at'    =>$add->created_at->format('Y-m-d-H:i:s'),
            'updated_at'    =>$add->updated_at->format('Y-m-d-H:i:s')

         
        ];
    }

    public function includeComments( $add)
    {
        $comment = $add->comments;
         if($comment){
        return $this->collection($comment, new CommentTransformer);
         }

    }
    
    public function includeUsers( $add)
    {
        $user = $add->user;
         if($user){
        return $this->item($user, new UserTransformer);
         }

    }

}