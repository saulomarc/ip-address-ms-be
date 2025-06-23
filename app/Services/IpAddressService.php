<?php

namespace App\Services;

use App\Models\IpAddress;

class IpAddressService implements GenericService
{
    function fetchData($request) {
        $ip_addresses = IpAddress::filter($request);

        if ($request->has('items')) {
            $ip_addresses = $ip_addresses->paginate($request->items);
        } else {
            $ip_addresses = $ip_addresses->get();
        }
        
        return response()->json(
            [
             'ip_addresses' => $ip_addresses,
            ], 200
        );
    }
}
