<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\RolesRepository;
use App\Services\UserService;
use App\Services\RoleUserService;
use App\Services\AddressService;
use App\Services\PhoneService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    use JsonResponse;

    private $userService;
    private $roleUserService;
    private $addressService;
    private $phoneService;
    private $rolesRepository;

    public function __construct(UserService $userService, RoleUserService $roleUserService, AddressService $addressService, PhoneService $phoneService, RolesRepository $rolesRepository) {
        $this->userService = $userService;
        $this->roleUserService = $roleUserService;
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

        $this->roleUserService->assignRoleToUser($idUserCreate, $customerRoleId);

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

        $newUser = $this->userService->newUser($userData);
        $newUserId = $newUser['id'];

        $this->roleUserService->assignRoleToUser($newUserId, $userRoles);
        $this->addressService->addAddress($newUserId, $addressData);
        $this->phoneService->addPhone($newUserId, $phonesData);

        return $this->successResponse([
            'user' => $userData[0]['user'],
            'roles' => $userRoles,
            'addressData' => $addressData,
            'PhonesData' => $phonesData
        ],201);
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

    public function showAllUsers () {
        $userList = $this->userService->allUsers();
        return $this->successResponse($userList, 200);
    }

    public function showUserById (Request $request) {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|numeric|max:4|exists:users,id'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $userId = $request->userId;

        return $this->userService->userById($userId);
    }
}
