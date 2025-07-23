<?php

namespace App\Http\Controllers\Users;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ExportUsers extends Controller
{
    public function __invoke()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
