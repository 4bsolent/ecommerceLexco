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
        return $this->roleUserService->getAllRoleUser();
    }
}
