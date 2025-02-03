<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PhoneService;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhoneController extends Controller
{
    
    use JsonResponse;

    public $phoneService;

    public function __construct(PhoneService $phoneService)
    {
        $this->phoneService = $phoneService;
    }

    public function createPhone(Request $request) {

        $validator = Validator::make($request->all(), [
            'id_user' => 'required|numeric|exists:users,id',
            'phones' => 'required|array',
            'phones.*.prefix' => 'required|string|max:5',
            'phones.*.number' => 'required|numeric|digits_between:7,14'
        ]);

        if($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }
        
        return $this->phoneService->addPhone($request->all());
    }
}
