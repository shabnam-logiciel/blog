<?php
use Sorskod\Larasponse\Larasponse;
use Post;
use User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use transformer\PostTransformer;
use transformer\CommentTransformer;
use traits\SortTrait;



class PostsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
     protected $response;

	  use SortTrait;

    public function __construct(Larasponse $response)
    {
        $this->response = $response;

        // The Fractal parseIncludes() is available to use here
		if(Input::get('includes')){
            $this->response->parseIncludes(Input::get('includes'));
			
        }
    }

	public function index()
	{
	
	    $posts = Post::query();
		$title = Request::get('title');
		$limit =  Request::get('limit');  
		$user_id = Request::get('user_id');
		$username = Request::get('username');
		$is_favourite = Request::get('is_favourite');

		if(!$limit){
			$limit = 10;
		 }
        if($user_id){
			$posts->whereIn('user_id',$user_id);
	
		}

       
    if($username){
         $posts->leftJoin('users','posts.user_id', '=','users.id')
		 ->whereIn('first_name',$username);
		}


       if($title){
        $posts->where('title','LIKE',"%$title%");
	
	   }



	   if($is_favourite){
        $posts->whereIn('is_favourite',$is_favourite);
	   }

	   
	    $posts->select('posts.*');
        $post=$posts->paginate($limit);
		$posts = $this->sortabletrait($post,$limit);
		// $data = Post::paginate($limit);                                                            
        return Response::json($this->response->paginatedCollection($posts, new PostTransformer));
	    // return Response::json($data);
 
	}


	public function store()
    {
        $id = Auth::id();
		// dd($id);
		
        $rules=[
            'title'=> 'required|unique:posts|max:20',
            'description'=> 'required|max:200'
        ];

        $validation = Validator::make(Input::all(),$rules);
        if($validation->fails()){
            return Response::json($validation->errors(),412);
        }

        $add = new Post;
        $message = [
            ['messege'=>'record inserted sucessfully'],
           [$add]
		];

		$add->id = Request::get('id');
		$add->user_id = Auth::Id();
        $add->title = Request::get('title');
        $add->description = Request::get('description');
        $add->save();
        return $message;
		
	}



	public function addfavourite()
	{
		
		$add = Post::Find(Input::get('post_id'));
		$add->is_favourite = Input::get('is_favourite');
		$add->marked_by = Auth::Id();
		$add->save();
         
		return Response::json(["message => Favourite Successfully"],200);


    }

	public function show($id)
	{
        $add = Post::find($id);
	    if($add){

         return $add;
		}
	
			return Response::json([
				"message" => "Record Not Found "
			  ], 404 );
	}
	


	public function update($id)
	{
          $valid = Validator::make(Input::all(),[
                                                                                                    
         'title' => 'required|max:20|unique:posts,title'. ($id ? ",$id" : ''),
         'description' => 'required|max:200'
     	 ]);

       if ($valid->fails())
       {
        return Response::json(
              ['error'=>$valid->errors()],
              412
          );
        }
		
		$add=Post::find($id);
   
		$message=[
           ['messege'=>'record updated sucessfully'],
            [$add]
		];

		if($add){
		$add->title = Request::get('title');
		$add->description = Request::get('description');
        $add->save();
		return $message;
		}

		  return Response::json([
			"message" => "Records Not Found "
		  ], 404 );
		
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$add=Post::find($id);
		if($add){
        $add->delete();
      
		return Response::json([
			"message" => "Records Deleted Successfully"
		  ], 200 );
		}
	
		  return Response::json([
			"message" => "Record Not Found "
		  ], 404 );
	
		
	}
	
	
  
	

























}
	