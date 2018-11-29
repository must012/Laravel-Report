<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    protected $dontFlash = ['files'];

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
            //
            'title' => ['required'],
            'writer' => ['required'],
            'name' => ['required','max:20'],
            'upFiles' => ['array'],
            'upFiles.*' => ['mimes:jpg,png,zip,tar'],
        ];

    }

    public function messages()
    {
        return [
            'required' => ':attribute 는 입력되어야 합니다',
            'min'=>':attribute 는 최소 :min 글자 이상이 필요합니다',
            'max'=>':attribute 는 최대 :max 글자 이하입니다'
        ];
    }

    public function attribute()
    {
        return [
            'title'=>'제목'
        ];
    }

}
