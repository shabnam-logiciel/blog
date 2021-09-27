<?php

use Sorskod\Larasponse\Larasponse;

use transformer\CommentTransformer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Comment;

  
class CommentController extends \BaseController {

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
        $post_id = Request::get('post_id');
		$limit =  Request::get('limit');  

		if(!$limit){
			$limit = 10;
		 }

        // $comment = Comment::where('post_id','LIKE',"%$post_id%")->paginate($limit);
		$comment = Comment::whereNull('parent_id')->paginate($limit);
        return Response::json($this->response->paginatedCollection($comment, new CommentTransformer));		 
		
 
	}
	

	public function store()
	{
		$validation = Validator::make(Input::all(),[
                                                                                                    
			'post_id'=> 'required|integer',
            'comments'=> 'required|max:200'
			 ]);

		  if ($validation->fails())
		  {
		   return Response::json(
				 ['error'=>$validation->errors()],
				 404
			 );
			}
		
	    $comment=new Comment;
        $comment->user_id = Authorizer::getResourceOwnerId();
        $comment->post_id = Request::get('post_id');
        $comment->comments = Request::get('comments');

        if(input::get('parent_id')){
        $current = Comment::where('id', '=', input::get('parent_id'))->first();

        if($current && ($n = $current->parent) && ($n->parent) ) {
        return Response::json(["meesege"=>"record is invalid"],400);
        }

        $comment->parent_id = Request::get('parent_id');
	    }
                    $comment->save();
                    $messege=[
                        ['messege'=>'record inserted sucessfully'],
                        [$comment]
					];
                    return $messege;
	} 


	public function destroy($id)
	{
		
		$comment=Comment::find($id);
		if($comment){
        $comment->delete();
      
		return Response::json([
			"message" => "Records Deleted Successfully"
		  ], 200 );
		}
		  return Response::json([
			"message" => "Record Not Found "
		  ], 404 );
		
		
	}


	public function update($id)
	{
          $valid = Validator::make(Input::all(),[
                                                                                                    
        //  'post_id' => 'required|max:20',
         'comments' => 'required|max:200'
     	 ]);

       if ($valid->fails())
       {
        return Response::json(
              ['error'=>$valid->errors()],
              412
          );
        }

		$comment=Comment::find($id);
   
		$message=[
          ['messege'=>'record updated sucessfully'],
           [$comment]
		];

		if($comment){
		// $comment->post_id = Request::get('post_id');
		$comment->comments = Request::get('comments');
        $comment->save();
		return $message;
		}
		  return Response::json([
			"message" => "Records Not Found "
		  ], 404 );
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	 
	


}
