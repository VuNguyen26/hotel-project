<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'required_without:phone', 'email', 'max:255'],
            'phone' => ['nullable', 'required_without:email', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'email.required_without' => 'Vui lòng nhập email hoặc số điện thoại.',
            'email.email' => 'Email không đúng định dạng.',
            'phone.required_without' => 'Vui lòng nhập số điện thoại hoặc email.',
            'subject.required' => 'Vui lòng nhập chủ đề liên hệ.',
            'message.required' => 'Vui lòng nhập nội dung liên hệ.',
            'message.min' => 'Nội dung liên hệ nên có ít nhất 10 ký tự.',
        ];
    }
}