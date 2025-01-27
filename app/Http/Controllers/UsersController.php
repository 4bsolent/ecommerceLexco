<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\RolesRepository;
use App\Services\UsersService;
use App\Services\RoleUserService;
use App\Services\AddressService;
use App\Services\PhoneService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    use JsonResponse;

    private $userService;
    private $roleUser;
    private $addressService;
    private $phoneService;
    private $rolesRepository;

    public function __construct(UsersService $userService, RoleUserService $roleUser, AddressService $addressService, PhoneService $phoneService, RolesRepository $rolesRepository) {
        $this->userService = $userService;
        $this->roleUser = $roleUser;
        $this->addressService = $addressService;
        $this->phoneService = $phoneService;
        $this->rolesRepository = $rolesRepository;
    }

    public function customerCreateUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'userData' => 'array|required',
            'userData.*.user' => 'required|string|unique:users,user|max:255',
            'userData.*.password' => 'required|string|min:7',
            'userData.*.name' => 'required|string|max:125',
            'userData.*.lastname' => 'required|string|max:125',
            'userData.*.email' => 'required|email|unique:users,email|max:150'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $userData = $request->userData;
        $newUser = $this->userService->newUser($userData);
        $idUserCreate = $newUser->id;
        $customerRole = $this->rolesRepository->getByRole('cliente');
        $customerRoleId [] = $customerRole->id;

        $this->roleUser->assignRoleToUser($idUserCreate, $customerRoleId);

        return $this->successResponse(['user' => $newUser->user], 201);
    }

    public function adminCreateUser(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'userData' => 'array|required',
            'userData.*.user' => 'required|string|unique:users,user|max:255',
            'userData.*.password' => 'required|string|min:8',
            'userData.*.name' => 'required|string|max:120',
            'userData.*.lastname' => 'required|string|max:120',
            'userData.*.email' => 'required|email|unique:users,email|max:150',
            'userRoles' => 'required|array',
            'addressData' => 'array',
            'addressData.*.city' => 'required|string|max:100',
            'addressData.*.neighborhood' => 'required|string|max:150',
            'addressData.*.nomenclature' => 'required|string|max:255',
            'phonesData' => 'required|array',
            'phonesData.*.prefix' => 'required|string|max:5',
            'phonesData.*.number' => 'required|numeric|digits_between:7,14'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $userData = $request->userData;
        $userRoles = $request->userRoles;
        $addressData = $request->addressData;
        $phonesData = $request->phonesData;

        return $phonesData;
        
        return $this->userService->newUser($userRoles);
    }

    public function loginUser (Request $request) {
        
        // Validación de los datos de entrada

        $validator = Validator::make($request->all(), [
            'user' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        // Respuesta Validación de usuario
        
        return $this->userService->validateUserLogin($request->all());
        
    }
}
