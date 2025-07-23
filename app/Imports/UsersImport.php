<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new User([
            'full_name' => $row['full_name'] ?? null,
            'password' => Hash::make($row['password'] ?? 'defaultpassword'), 
        ]);
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'full_name.required' => 'The full_name column is missing from the Excel file',
             'password.required' => 'The password column is missing from the Excel file',
        ];
    }


    public function prepareForValidation($data, $index)
    {
        return [
            'full_name' => $data['full_name'] ?? null,
            'password' => $data['password'] ?? null,
        ];
    }
}