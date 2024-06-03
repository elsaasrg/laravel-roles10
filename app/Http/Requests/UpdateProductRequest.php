<?php
 namespace App\Http\Requests;
 use Illuminate\Foundation\Http\FormRequest;
 class UpdateProductRequest extends FormRequest
 {
 /**
 *Determineiftheuserisauthorizedtomakethisrequest.
 */
 public function authorize(): bool
 {
 return true;
 }
 /**
 *Getthevalidationrulesthatapplytotherequest.
 *
 *@returnarray<string,
 \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>

*/
public function rules(): array
{
return [
'name' => 'required|string|max:250',
'nim' => 'required|string'
];
}
}