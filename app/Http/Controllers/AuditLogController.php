<?php

namespace App\Http\Controllers;

use App\Services\AuditLogService;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function __construct(protected AuditLogService $auditLogService)
    {
        
    }

    public function fetchUserSessions(Request $request)
    {
        return $this->auditLogService->fetchUserSessions($request);
    }

    public function fetchIpAddressLogs(Request $request)
    {
        return $this->auditLogService->fetchIpAddressLogs($request);
    }
}
