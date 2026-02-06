<?php

namespace Extensions\Hrm\Http\Controllers\Api;

use App\Exceptions\BadException;
use App\Http\Controllers\Controller;
use Core\BusinessRole\Domain\Services\BusinessRoleService;
use Extensions\Hrm\Services\DownloadCsvService;
use Extensions\Hrm\Services\LeaveService;
use Extensions\Hrm\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExportExcelController extends Controller
{
    public function __construct(
        private DownloadCsvService $downloadCsvService,
        private BusinessRoleService $businessRoleService
    ) {}
    public function index(Request $request): JsonResponse{
        $validated = $request->validate([]);
        $role = $this->businessRoleService->findOne([
            "business_id" => $request->get('business_id'),
            "role_user_id" => $request->get('user_id'),
        ]);
        if ($role->isAdmin() || $role->isManager()) {
            $validated['permission'] = true;
        }
        $validated['user_id'] = $request->get('user_id');
        $validated['business_id'] = $request->get('business_id');
        return response()->json([
            "message" => $this->downloadCsvService->index($validated)
        ]);
    }
    public function show(Request $request,string $id): JsonResponse {
        $validated = $request->validate([]);
        $role = $this->businessRoleService->findOne([
            "business_id" => $request->get('business_id'),
            "role_user_id" => $request->get('user_id'),
        ]);
        $validated['id'] = $id;
        if ($role->isAdmin() || $role->isManager()) {
            $validated['permission'] = true;
        } 
        return response()->json([
            'message' => $this->downloadCsvService->findOne($validated)
        ]);
    }
}
