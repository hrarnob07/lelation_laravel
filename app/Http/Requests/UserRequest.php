<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\Throw_;

class UserRequest extends FormRequest{
    /**
     * Get the validation rules that apply to the request.
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * make rule for validation
     * @return array
     */

    public function rules()
    {
        return [
            'name' => 'string|required',
            'password' => 'string|required',
            'phone_no' =>'required|string|unique:users',
            'email'=>'string|nullable',
            'status'=>'in:active,pending,inactive|nullable',
            'role'=>'in:admin,user|nullable',
            'address'=>'string|nullable',
            'gender'=>'string|nullable',
            'age'=>'int|nullable',
            'attachment'=>'string|nullable'
        ];

    }

    public function failedValidation(Validator $validator)
    {
       $returnResponse =  response()->json([
           'success' => false,
           'message' => $validator->errors()->first()
       ]);

       throw    new ValidationException($validator , $returnResponse);
    }
}
