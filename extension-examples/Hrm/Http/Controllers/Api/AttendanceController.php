<?php

namespace Extensions\Hrm\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Core\BusinessRole\Domain\Services\BusinessRoleService;
use Extensions\Hrm\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AttendanceController extends Controller
{
    public function __construct(
        private AttendanceService $attendanceService,
        private BusinessRoleService $businessRoleService
    ) {}

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'note' => 'nullable|string',
        ]);

        $validated['user_id'] = $request->get('user_id');
        $validated['business_id'] = $request->get('business_id');
        $validated['user_agent'] = $request->userAgent();
        $validated['ip'] = $request->ip();

        $attendance = $this->attendanceService->store($validated);

        return response()->json([
            'message' => $attendance
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'note' => 'nullable|string'
        ]);
        $validated['user_id'] = $request->get('user_id');
        $validated['business_id'] = $request->get('business_id');
        $validated['id'] = $id;
        $role = $this->businessRoleService->findOne([
            "business_id" => $request->get('business_id'),
            "role_user_id" => $request->get('user_id'),
        ]);
        if ($role->isAdmin() || $role->isManager()) {
            $validated['approved'] = $request->get('approved');
        } else {
            $validated['note'] = $request->get('note') ?? null;
        }
        
        return response()->json([
            'message' => $this->attendanceService->update($validated)
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2020|max:' . (date('Y', time()) + 1),
        ]);
        $validated['user_id'] = $request->get('user_id');
        $validated['business_id'] = $request->get('business_id');
        $role = $this->businessRoleService->findOne([
            "business_id" => $request->get('business_id'),
            "role_user_id" => $request->get('user_id'),
        ]);
        if ($role->isAdmin() || $role->isManager()) {
            $validated['permission'] = true;
        }
        return response()->json([
            'message' => [
                'list' => $this->attendanceService->index($validated),
                'permission' => $validated['permission'] ?? false
            ]
        ]);
    }
}
