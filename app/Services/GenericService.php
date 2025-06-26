<?php

namespace App\Services;

use Illuminate\Http\Request;

interface GenericService
{
    public function fetchData(Request $request);
    public function addData(Request $request);
}
