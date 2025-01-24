<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository {
    
    public function newAddress($data) {
        return Address::create([
            'id_user' => $data['id_user'],
            'city' => $data['city'],
            'neighborhood' => $data['neighborhood'],
            'nomenclature' => $data['nomenclature']
        ]);
    }
}

