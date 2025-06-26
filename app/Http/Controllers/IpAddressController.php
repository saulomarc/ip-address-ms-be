<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddIpAddressRequestForm;
use App\Http\Requests\EditIpAddressRequestForm;
use App\Models\IpAddress;
use App\Services\IpAddressService;
use Illuminate\Http\Request;

class IpAddressController extends Controller
{
    public function __construct(protected IpAddressService $ipAddressService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->ipAddressService->fetchData($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddIpAddressRequestForm $request)
    {
        return $this->ipAddressService->addData($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, IpAddress $ipAddress)
    {
        return $this->ipAddressService->fetchOneResouce($request, $ipAddress->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditIpAddressRequestForm $request, string $id)
    {
        return $this->ipAddressService->editData($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, IpAddress $ipAddress)
    {
        return $this->ipAddressService->deleteData($request, $ipAddress->id);
    }
}
