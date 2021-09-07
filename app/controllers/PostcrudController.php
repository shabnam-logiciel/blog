<?php
use Sorskod\Larasponse\Larasponse;
use Post;
use User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use transformer\PostTransformer;
use transformer\CommentTransformer;



class PostcrudController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	protected $response;

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
		// $data = Post::paginate();
	  
		$title = Request::get('title');
		$limit =  Request::get('limit');  
		$user_id = Request::get('user_id');
		$username = Request::get('username');
		if(!$limit){
			$limit = 10;
		 }
        if($user_id){
	    $data = Post::select("*")
	    ->whereIn('user_id',$user_id)
	    ->get();
        return Response::json($this->response->Collection($data, new PostTransformer));
		}
       
       else if($username){
         $user = Post::leftJoin('users','posts.user_id', '=','users.id')
		 ->whereIn('first_name',$username)
		 ->get();
		 return Response::json($this->response->Collection($user, new PostTransformer));

		}

        $add = Post::where('title','LIKE',"%$title%")->paginate($limit);
		// $post=($limit==0) ? "10":"$limit";
	
		// $data = Post::paginate($limit) ;                                                            
        return Response::json($this->response->paginatedCollection($add, new PostTransformer));
	    // return Response::json($data);
	
 
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}
	

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
    {
        $id= Auth::id();
		// dd($id);
		
        $rules=[
            'title'=> 'required|unique:posts|max:20',
            'description'=> 'required|max:200'
        ];
        $validation=Validator::make(Input::all(),$rules);
        if($validation->fails()){
            return Response::json($validation->errors(),412);
        }
        $add=new Post;
        $message=array(
            array('messege'=>'record inserted sucessfully'),
            array($add)
        );

		$add->id = Request::get('id');
		$add->user_id = Authorizer::getResourceOwnerId();
        $add->title = Request::get('title');
        $add->description = Request::get('description');
        $add->save();

        return $message;
		
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
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
   
		$message=array(
            array('messege'=>'record updated sucessfully'),
            array($add)
        );

		if($add){
		$add->title = Request::get('title');
		$add->description = Request::get('description');
        $add->save();
		return $message;
		}
		else{
		  return Response::json([
			"message" => "Records Not Found "
		  ], 404 );
		}
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
		else{
		  return Response::json([
			"message" => "Record Not Found "
		  ], 404 );
		}
		
	}
	
	
  
	

























}
	