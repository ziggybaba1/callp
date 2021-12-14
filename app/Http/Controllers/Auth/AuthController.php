<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Traits\Response as Callback;
use DB;
use App\Models\User;
use App\Classes\Table;

class LoginController extends Controller
{
    use Callback;
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make(isset($request->all()['data'])?$request->all()['data']:$request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
            if($validator->fails()) return $this->failureResponse(401,$validator->errors()->first());
            $request=$this->reset($request->all());
           
        //Request is validated
        //Crean token
        if (! $token = auth()->attempt(['email'=>$request->email,'password'=>$request->password])) {
            return $this->failureResponse(401,'Unauthorized.');
            
        }
        
        try {
            if (! $token = JWTAuth::attempt(['email'=>$request->email,'password'=>$request->password])) {
                return $this->failureResponse(400,'Login credentials are invalid.');
            }
        } catch (JWTException $e) {
    	// return $credentials;
        return $this->failureResponse(500,'Could not create token.');
        }
        	//Token created, return with success response and jwt token
        $returnStatus=[
            'token'=>$token,
        ];
 	return $this->successResponse(200,'success',$returnStatus);
    }

    public function getAuthenticatedUser()
    {
            try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                            return $this->failureResponse(404,'user not found');
                    }

            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return $this->failureResponse($e->getStatusCode(),'token expired');

            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return $this->failureResponse($e->getStatusCode(),'token invalid');

            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                return $this->failureResponse($e->getStatusCode(),'token absent');
            }
            $returnStatus=[
                'user'=>$user,
                'details'=>\App\Models\UserDetail::find($user->id)
            ];
            return $this->successResponse(200,'success',$returnStatus);
    }

    public function logout() 
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return $this->successResponse(200,'Logout successfull','');
    }

    public function getAllUserInfo()
    {
        if (! $token = JWTAuth::parseToken()) {
            return $this->failureResponse(401,'denied');
        }
        $data = table::users()
		->join('user_details', 'users.id', '=', 'user_details.user_id')
		->join('user_accounts', 'users.id', '=', 'user_accounts.user_id')
		->paginate(30);
    }
}
