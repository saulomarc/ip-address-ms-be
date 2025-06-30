<?php

namespace App\Services;

use App\Models\IpAddress;
use App\Models\UserSession;
use Illuminate\Http\Request;

class AuditLogService
{
    public function fetchUserSessions(Request $request)
    {
        $user_sessions = UserSession::filter($request)->withLogs();

        if ($request->has('items')) {
            $user_sessions = $user_sessions->paginate($request->items);
        } else {
            $user_sessions = $user_sessions->get();
        }
        
        return response()->json(
            [
             'user_sessions' => $user_sessions,
            ], 200
        );
    }

    public function fetchIpAddressLogs(Request $request)
    {
        $ip_addresses = IpAddress::filter($request)->withLogs();

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