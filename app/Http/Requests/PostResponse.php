<?php


namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PostResponse extends FormRequest
{
    /**
     * @return bool
     */

    public function authorize(){
        return true;
    }

    /**
     * make rule for validation
     * @return array
     */
    public function rules(){
        return [
            'body'=> 'string|required',
            'attachment'=>'array|nullable'
          ];
    }

    public function failedValidation(Validator $validator)
    {
        $returnResponse =  response()->json([
            'success'=> false,
            'message'=> $validator->errors()->first()
        ]);

        throw  new ValidationException( $validator , $returnResponse);
    }
}
