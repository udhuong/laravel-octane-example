<?php

namespace Core\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Xác định xem người dùng có được phép thực hiện request này hay không
        // Bình thường thì sẽ trả về true
        // Nếu muốn kiểm tra quyền truy cập thì: auth()->user()->isAdmin(); // Chỉ cho phép admin thực hiện request, k thỏa mãn trả 403
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
