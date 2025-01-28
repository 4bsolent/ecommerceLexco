<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository {
    
    public function newAddress(int $userId, array $addressData) {
        return Address::create([
            'id_user' => $userId,
            'city' => $addressData['city'],
            'neighborhood' => $addressData['neighborhood'],
            'nomenclature' => $addressData['nomenclature']
        ]);
    }
}

