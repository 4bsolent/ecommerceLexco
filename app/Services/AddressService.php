<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use App\Traits\JsonResponse;

class AddressService {

    use JsonResponse;

    public $addressRepository;

    public function __construct(AddressRepository $addressRepository) {
        $this->addressRepository = $addressRepository;
    }

    public function addAddress (int $userId, array $addressData) {
        foreach ($addressData as $address) {
            $this->addressRepository->newAddress( $userId, $address);
        }

        return $this->successResponse([
            'addressData' => $addressData,
            'userId' => $userId
        ], 201);
    }
}
