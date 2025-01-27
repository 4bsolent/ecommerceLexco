<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AddressService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller {
    
    use JsonResponse;

    public $addressService;

    public function __construct(AddressService $addressService) {
        $this->addressService = $addressService;
    }

    public function createAddress (Request $request) {

        $validator = Validator::make($request->all(), [
            'id_user' => 'required|numeric|exists:users,id',
            'city' => 'required|string',
            'neighborhood' => 'required|string',
            'nomenclature' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $this->addressService->addAddress($request->all());

        return $this->successResponse($request->all(), 201);
    }
}
