<?php


namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
          'post_id' => 'required',
          'body'=>'string|required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $returnResponse = response()->json([
           'success'=> false,
           'message'=> $validator->errors()->first()
        ]);

        throw new ValidationException($validator , $returnResponse);
    }

}
