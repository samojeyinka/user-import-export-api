<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select('id', 'full_name', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Created At'
        ];
    }
}