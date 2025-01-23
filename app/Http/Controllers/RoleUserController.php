<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleUserService;
use App\Traits\JsonResponse;

class RoleUserController extends Controller
{
    use JsonResponse;

    private $roleUserService;

    public function __construct(RoleUserService $roleUserService) {
        $this->roleUserService = $roleUserService;
    }

    public function newRoleUser(Request $request) {
        
        return $this->roleUserService->newRoleUser($request->all());
        
    }
}
