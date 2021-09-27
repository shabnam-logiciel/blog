<?php
  
namespace transformer;
use Post;
use League\Fractal\TransformerAbstract;


class PostExcelTransformer extends TransformerAbstract
{




    public function transform($add)
    {
     
        return [
            'username'         => $add->user->first_name,
            'title'           =>$add->title,
            'description'   => $add->description,
            'is_favourite'  =>$add->is_favourite,
            'marked_by'     =>$add->user->first_name,
            

         
        ];
    }

   


}