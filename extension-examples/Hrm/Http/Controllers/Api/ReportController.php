<?php

namespace Extensions\Hrm\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Core\BusinessRole\Domain\Services\BusinessRoleService;
use Extensions\Hrm\Services\LeaveService;
use Extensions\Hrm\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function __construct(
        private ReportService $reportService,
        private BusinessRoleService $businessRoleService
    ) {}
    public function index(Request $request): JsonResponse{
        $validated = $request->validate([
            "keywords"=> "nullable|max:150|string",
        ]);
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
            "message" => $this->reportService->index($validated)
        ]);
    }
    public function store(Request $request): JsonResponse {
        $validated = $request->validate([
            'summary'=> 'required|max:10000',
            'issues'=> 'nullable|max:10000',
            'tasks_done'=> 'nullable|max:10000',
        ]);
        $validated['user_id'] = $request->get('user_id');
        $validated['business_id'] = $request->get('business_id');
        return response()->json([
            'message' => $this->reportService->store($validated),
        ]);
    }
}
