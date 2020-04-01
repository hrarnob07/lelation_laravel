<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\Throw_;

class AuthRequest extends FormRequest
{
   /**
    * Get the validation rules that apply to the request.
    * @return bool
    */
   public  function authorize()
   {
        return true;
   }

   /**
    * make rule for validation
    * @return array
    */

   public function rules()
   {
       return [
           'username' => 'string|required',
           'password' => 'string|required',

       ];

   }

   public function failedValidation(Validator $validator)
   {
        $returnResponse = response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ]);

        throw  new ValidationException($validator , $returnResponse);
   }
}
