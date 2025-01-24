<?php

namespace App\Services;

use App\Repositories\PhoneRepository;
use App\Traits\JsonResponse;

class PhoneService {

    use JsonResponse;

    public $phoneRepository;

    public function __construct(PhoneRepository $phoneRepository){
        $this->phoneRepository = $phoneRepository;
    }

    public function addPhone ($data) {

        $idUser = $data['id_user'];
        $phonesData = $data['phones'];
        $numbersAlreadyRegistered = [];

        foreach ($phonesData as $phoneData) {

            $prefix = $phoneData['prefix'];
            $phoneNumber = $phoneData['number'];

            $validatorNumber = $this->phoneRepository->isPhoneAlreadyRegistred($idUser, $prefix, $phoneNumber);

            if ($validatorNumber) {
                $numbersAlreadyRegistered[] = $prefix . ' ' . $phoneNumber;
            } else {
                $this->phoneRepository->newPhone($idUser, $prefix, $phoneNumber);
            }
        }

        if (!empty($numbersAlreadyRegistered)) {
            return $this->errorResponse([
                'message' => 'Los siguientes números ya se encuentran registrados:',
                'phoneNumbers' => $numbersAlreadyRegistered
            ],422);
        } else {
            return $this->successResponse($phonesData, 201);
        }
    }
}
