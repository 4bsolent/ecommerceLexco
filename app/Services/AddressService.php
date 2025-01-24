<?php

namespace App\Services;

use App\Repositories\AddressRepository;
use App\Traits\JsonResponse;

class AddressService {

    public $addressRepository;

    public function __construct(AddressRepository $addressRepository) {
        $this->addressRepository = $addressRepository;
    }

    public function addAddress ($data) {
        $this->addressRepository->newAddress($data);
    }
}
