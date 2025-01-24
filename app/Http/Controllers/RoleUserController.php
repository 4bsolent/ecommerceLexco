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
            'id_role' => 'required|array|exists:roles,id',
            'id_user' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $idUser = (int) $request->id_user;
        $idRoles = (array) $request->id_role;

        return $this->roleUserService->assignRoleToUser($idUser, $idRoles);
        

    }
}
