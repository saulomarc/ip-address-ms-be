<?php

namespace App\Services;

use App\Models\IpAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface GenericService
{
    public function fetchData(Request $request);
    public function addData(Request $request);
    public function deleteData(Request $request, $id);
}
