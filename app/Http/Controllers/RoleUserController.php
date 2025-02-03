<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleUserService;
use App\Traits\JsonResponse;
use Illuminate\Support\Facades\Validator;

class RoleUserController extends Controller
{
    use JsonResponse;

    private $roleUserService;

    public function __construct(RoleUserService $roleUserService) {
        $this->roleUserService = $roleUserService;
    }

    public function createRoleUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|numeric|exists:roles,id',
            'rolesBeAssigned' => 'required|array|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $userId = $request->userId;
        $rolesToBeAssigned = $request->rolesBeAssigned;

        $assignedRoles = [];
        $alreadyAssignedRoles = [];
        
        foreach ($rolesToBeAssigned as $roleId) {
            $validationRole = $this->roleUserService->validationOfAssignedRole($userId, $roleId);

            if (!$validationRole) {
                $assignedRoles [] = $roleId;

                $this->roleUserService->assignRoleToUser($userId, $roleId);
            } else {
                $alreadyAssignedRoles [] = $roleId;
            }
        }

        return $this->successResponse([
            'assignedRoles' => $assignedRoles,
            'alreadyAssignedRoles' => $alreadyAssignedRoles
        ], 200);
    }

    public function showAllRoleUser () {
        $allRoleUser = $this->roleUserService->getAllRoleUser();

        return $this->successResponse($allRoleUser, 200);
    }

    public function showAllRoleUserByUserId(Request $request) {
        $validator = validator::make($request->all(), [
            'userId' => 'required|numeric|exists:users,id'
        ]);

        if($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $userId = $request->userId;
        $roleUserByUser = $this->roleUserService->getAllRoleUserByUserId($userId);

        return $this->successResponse($roleUserByUser, 200);

    }

    public function editRoleUserStatus(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'roleUserId' => 'required|numeric|exists:role_user,id',
            'newStatus' => 'required|string|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $roleUserId = $request->roleUserId;
        $newStatus = $request->newStatus;

        return $this->roleUserService->updateRoleUserStatus($roleUserId, $newStatus);
    }

    public function removeRoleUser(Request $request) {
        $validaotor = Validator::make($request->all(), [
            'roleUserId' => 'required|numeric|exists:role_user,id',
        ]);

        if ($validaotor->fails()) {
            return $this->errorResponse($validaotor->errors(), 422);
        }

        $roleUserId = $request->roleUserId;

        return $this->roleUserService->deleteRoleUser($roleUserId);
    }
}
