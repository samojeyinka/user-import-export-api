<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ImportUsers extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        return response()->json([
            'success' => true,
            'message' => 'Users imported successfully',
        ]);
    }
}
