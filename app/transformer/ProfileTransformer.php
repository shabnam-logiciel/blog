<?php
namespace transformer;
use Profile;
use League\Fractal\TransformerAbstract;
class ProfileTransformer extends TransformerAbstract
{
    
  
    public function transform($profile)
    {
        return [
            // 'id'            => $profile->id,
            // 'user_id'       =>$profile->user_id,
             'image'      => $profile-> image
            //  'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            //  'updated_at' => $user->updated_at->format('Y-m-d H:i:s')     
         ];
    }
   
}