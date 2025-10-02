<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Services\StudentApi;
use Illuminate\Support\Facades\Http;

class GetStudentApi extends Controller
{
    public function getDataAbsen()
    {
        $ser = new StudentApi();
        $ser->importData();

    }
}
