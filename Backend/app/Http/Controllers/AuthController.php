<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Http\Request;
use App\Http\Requests\SigupRequest;
use App\User;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{
    
      /* public $successStatus = 200;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     **/
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','signup','Image','signupAdmin']]);
    }
    public function Image() 
    {  
        $image = DB::table('users')->where('id', '4')->value('image');
        return response()->json($image);
    } 
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
     public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) 
       
          {  return response()->json(['error' => ' l\'email et  le password n\'existe pas'], 401);
           
          }
       return  $this->respondWithToken($token);
     
       
    }
   
   
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
   public function me()
    {   
        return response()->json(auth()->user());
       
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'role'=>auth()->user()->role,
            'user' =>auth()->user()
        ]);
    }
    public function signup(SigupRequest $request)
    {  
        $user = User::create($request->all());
        $this->storeImage($user);
         return $this->login($user);
    } 
    public function signupAdmin(Request $request)
    {  
        $user = User::create($request->all());
           return $this->login($user);
    } 
    public function update(User $user)
    {
        $user->update($this->validateRequest());
        $this->storeImage($user);
    }
  
 private function storeImage($user)
    {    
      if (request()->has('image'))
      {
        $user->update([
            'image' => request()->image->store('uploads', 'public'),
        ]);
        $image = Image::make(public_path('storage/' . $user->image))->fit(300, 300, null, 'top-left');
        $image->save();
      }
    }
 
    public function details() 
    { 
        $user = Auth::User();
        return response()->json(['success' => $user]); 
    } 
  
}