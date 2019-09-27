<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeStudentPost extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|max:30',
            'age'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'姓名必填',
            'name.max'=>'姓名长度不能超过30',
            'age.required'=>'年龄必填',
            'age.numeric'=>'年龄必须为数字',
        ];
    }
}