<?php
namespace app\service;
use Carbon\Carbon;
use DB;
use app\repositories\ImageRepository;


class ImageService 
{
    function __construct(ImageRepository $repo) {
    $this->repo = $repo;
   
   }


    public function  image ($file)
    {
        $destinationPath = public_path().'/user_profile/';	
        $filename        = str_random(6) . '.' . $file->getClientOriginalExtension();
        $url =  ('/user_profile/').$filename;

        $uploadSuccess   = $file->move($destinationPath, $filename);
        $data = $this->repo->saveimage($filename,$url);
        return $data;
    }


}


?>