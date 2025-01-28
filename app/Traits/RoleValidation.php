<?php

namespace App\Traits;
use App\Models\RoleUser;

trait RoleValidation {

    /**
        * Validar Rol del Usuario
        *
        * Devuelve el rol del id del usuario ingresado
        *
        * @param int $userId -> ID del usuario al cual se le consultaran los roles asignados
        * @return array App\Traist\RoleValidation -> Array con los nombres de los roles asignados al usuario
    */

    public static function roleValidation ($userId) {
        return RoleUser::where('id_user', $userId)->pluck('id_role')->toArray();
    }
}
