<?php
namespace App\Services;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;

class UserImportService
{
    public function import(UploadedFile $file): array
    {
        Excel::import(new UsersImport, $file);
        
        return [
            'success' => true,
            'message' => 'Users imported successfully',
        ];
    }
}