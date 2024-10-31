<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoticeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'information_title' => 'required|max:100',
            'information_kbn' =>'required|max:1',
            'keisai_ymd' =>'required|max:8',
            'enable_start_ymd' =>'required|max:8',
            'enable_end_ymd' =>'required|max:8',
            'information_naiyo' =>'required',      
        ];
    }
}
