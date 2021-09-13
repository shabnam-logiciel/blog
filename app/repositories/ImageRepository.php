<?php 
namespace app\repositories;
use Illuminate\Filesystem\Filesystem;
use Profile;
use Illuminate\Support\Facades\Auth;

class ImageRepository
{

public function saveimage($filename,$url){
    
    $profile  = new Profile;
    $profile->user_id = Auth::Id();
    $profile->image = $url;
    $profile->save();
    return $profile;
 

}



}

?>