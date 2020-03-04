<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ResetPasswordController extends Controller
{
    //
    public function sendEmail(Request $request){    
    if(!$this->validateEmail($request->email)){
    
        return $this->failedResponse();
    }
    $this->send($request->email);
    return $this->successResponse();
    }

    public function send($email){
        $token=$this->createToken($email);
        Mail::to($email)->send(new ResetPasswordMail($token));
       // dd($dd);
    }
    public function createToken($email){
        $oldToken=DB::table('password_resets')->where('email',$email)->value('token');// pour chercher le token pour un email si il existe deja  dans la table pour un email il faut avoir un token 
       // $oldToken = DB::table('password_resets')->where('email',$email)->get('token');
        if($oldToken){
        return $oldToken;
    }
        $token=Str::random(60);
        $this->saveToken($token,$email);
        return $token;
    }
    public function saveToken($token,$email){

DB::table('password_resets')->insert([
    'email' => $email,
    'token' => $token,
    'created_at'=>Carbon::now()
]);
    }

    public function validateEmail($email){
        return !!User::where('email',$email)->first(); //!! cad boolean
    }
    public function failedResponse(){
        return response()->json([
            'error'=>'email does not found on database'
        ],Response::HTTP_NOT_FOUND);
    }
    public function successResponse(){
        return response()->json([
            'data'=>'reset email is send successfully please check your box'
        ],Response::HTTP_OK);
    }
}