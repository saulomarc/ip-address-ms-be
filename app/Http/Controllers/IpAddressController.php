<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
