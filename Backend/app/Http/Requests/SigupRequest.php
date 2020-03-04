<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class SigupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'nom' => 'required',
           'prenom' => 'required',
           'datenaiss'=> 'required|Date',
           'adresse' => 'required',
           'gouvernorats' => 'required',
           'role' => 'required',
           'codePostal' => 'Integer|Min:4',
           'email' => 'required|email|unique:users',
           'password' =>'required |confirmed',
           'image'=>'required | image',
        ];
   }
}
