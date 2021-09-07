<?php

use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Authorizer;
use Sorskod\Larasponse\Larasponse;
use User;
use app\service\AuthService;
use transformer\UserTransformer;

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
     protected $authservice;
	 protected $authorizer;
	 
	 function __construct(Larasponse $response,
	Authorizer $authorizer,
	AuthService $authservice)
    {
        $this->response = $response;
		$this->authorizer = $authorizer;
		$this->authservice = $authservice;	
        // The Fractal parseIncludes() is available to use here
		if(Input::get('includes')){
            $this->response->parseIncludes(Input::get('includes'));
			
        }
    }


	public function signup()
	{
		$data = Request::all();
        $rules=[
            'email'=> 'required|unique:users',
			'password'=> 'required|'
        ];
        $validation=Validator::make(Input::all(),$rules);
        if($validation->fails()){
            return Response::json($validation->errors(),412);
        }

        $add=new User;
        $add->first_name = $data['first_name'];
		$add->last_name = $data['last_name'];
        $add->email = $data['email'];
        $add->password = Hash::make($data['password']);
        $add->save();

        return Response::json([
         "message" => "SignUp Succesfully"
        ],200   );
    
 	}
	 public function login()
	{
		$user= Input::all();
		$user = User::where('email', Input::get('username'))->first();
		// dd($user);

		$token = $this->authorizer->issueAccessToken();
		// dd($token);
		$token = $this->authservice->verify($token);
		return Response::json([
			"message" => "Login Succesfully",
			$token
 		   ],200   );
	   
		

		
	}

	public function status()
    {
        $rules=[
            'active'=> 'required',
        ];
        $validation=Validator::make(Input::all(),$rules);
        if($validation->fails()){
            return Response::json($validation->errors(),412);
        }
        $status = Request::get('active');
        // $add=new User;
        // $add->is_active = Request::get('is_active');
        // $add->save();
        if($status==0){
            return Response::json([
                "message" => "inactive"
            ],201   );
        }
        else if($status==1){
            return Response::json([
                "message" => "active"
            ],201   );
        }
     
            return Response::json([
                "message" => "please enter valid boolean number"
            ],404   );
        

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


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}