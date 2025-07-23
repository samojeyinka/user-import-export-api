<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ImportUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:xlsx,xls|max:10240', 
            'queue' => 'sometimes|boolean', 
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Please upload a file',
            'file.mimes' => 'File must be an Excel file (.xlsx or .xls)',
            'file.max' => 'File size cannot exceed 10MB',
            'queue.boolean' => 'Queue parameter must be true or false',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}