<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //判断当前用户是否有权限进行添加用户
        return (bool)$_SESSION['is_admin'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => 'required|string|unique:users|max:255',
            'password' => 'required|min:6|max:20',
            'role_id' => 'required|integer'
        ];
    }
}
