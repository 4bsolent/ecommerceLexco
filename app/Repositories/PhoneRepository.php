<?php

namespace App\Repositories;

use App\Models\Phone;
use Iluminate\Database\Eloquent\Collection;

class PhoneRepository {
    public function newPhone($idUser, $prefix, $phoneNumber) {
        return Phone::create([
            'id_user' => $idUser,
            'prefix' => $prefix,
            'phone' => $phoneNumber
        ]);
    }

    public function getPhoneUser($idUser) {
        return Phone::where('id_user', $idUser)->get();
    }

    public function isPhoneAlreadyRegistred($idUser, $prefix, $phoneNumber) {
        return Phone::where('id_user', $idUser)
                    ->where('prefix', $prefix)
                    ->where('phone', $phoneNumber)
                    ->exists();
    }
}

