<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    //***Determineiftheuserisauthorizedtomakethisrequest.*/
 public function authorize():bool
 {
 return true;
 }
 /**
 *Getthevalidationrulesthatapplytotherequest.
 *
 *@returnarray<string,
 \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
 */
 public function rules():array
 {
 return[
 'name'=>'required|string|max:250',
 'email'=>'required|string|email:rfc,dns|max:250|unique:users,email',
 'password'=>'required|string|min:8|confirmed',
 'roles'=>'required'
 ];
 }
 }