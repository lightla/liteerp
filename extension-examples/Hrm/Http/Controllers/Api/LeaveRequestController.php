<?php

namespace Extensions\Hrm\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Core\BusinessRole\Domain\Services\BusinessRoleService;
use Extensions\Hrm\Services\LeaveService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LeaveRequestController extends Controller
{
    public function __construct(
        private LeaveService $leaveService,
        private BusinessRoleService $businessRoleService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $all = $request->all();
        $role = $this->businessRoleService->findOne([
            "business_id" => $all["business_id"],
            "role_user_id" => $all["user_id"],
        ]);
        if ($role->isAdmin() || $role->isManager()) {
            return response()->json([
                'message' => [
                    'list' => $this->leaveService->getLeaveRequestsAll($all),
                    'permission' => true,
                ],
            ]);
        }
        $leaveRequests = $this->leaveService->getLeaveRequestsForUser($all);
        return response()->json([
            'message' => [
                'list' => $leaveRequests,
                'permission' => false,
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'leave_type' => 'required|in:annual,sick,unpaid',
            'reason' => 'nullable|string',
        ]);
        $all = $request->all();
        $validated['user_id'] = $all['user_id'];
        $validated['business_id'] = $all['business_id'];

        $leaveRequest = $this->leaveService->createLeaveRequest($validated);

        return response()->json($leaveRequest);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);
        $validated['user_id'] = $request->all('user_id');
        $validated['business_id'] = $request->all('business_id');

        return response()->json(['message' => $this->leaveService->updateLeaveRequest($id, $validated)]);
    }
}
