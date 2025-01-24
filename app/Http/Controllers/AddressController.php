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
        return $request->all();
    }
}
