<?php
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Authorizer;
use Sorskod\Larasponse\Larasponse;
use User;
use Department;
use app\service\AuthService;
use app\service\ImageService;
use transformer\UserTransformer;
use transformer\ProfileTransformer;
use transformer\DepartmentTransformer;
use DB;

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
     protected $authservice;
	 protected $authorizer;
	 protected $imageService;
	 
	 function __construct(Larasponse $response,
    ImageService $imageService,
	Authorizer $authorizer,
	AuthService $authservice)
    {
        $this->response = $response;
		$this->authorizer = $authorizer;
		$this->imageService = $imageService;
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


        else if($status==1)
		{
            return Response::json([
                "message" => "active"
            ],201   );
        }


        return Response::json([
            "message" => "please enter valid boolean number"
            ],404  
	    );
		
    }



	public function uploadImage() 
	{
	
		$valid=[
			        'image'=> 'required|image|mimes:jpeg,png,jpg|max:2048',
			    ];

			    $validation=Validator::make(Input::all(),$valid);
			    if($validation->fails()){

			        return Response::json($validation->errors(),412);
			    }
				
				
		if (Input::hasFile('image')) {
			$file            = Input::file('image');
			$rule = $this->imageService->image($file);
			// $message=array(
			// 	array('messege'=>'image uploaded sucessfully'),
			// 	array($rule)
			// );
			return Response::json($this->response->item($rule, new ProfileTransformer));		
		}
	}
  

	public function index()
	{
	  $add = User::all();

	  return Response::json($this->response->collection($add, new UserTransformer));		
	}



	public function departmentindex()
	{
	     $dept = Department::all();

		 return Response::json($this->response->collection($dept, new DepartmentTransformer));		
	}




	public function departmentstore()
	{
	   $user = User::find(Input::get('user_id'));
	   $deptIds = Input::get('department_id');
	   $user->department()->sync((array)$deptIds);


	   return Response::json([
			"message" => " inserted Succesfully",
		   ],200   );
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
