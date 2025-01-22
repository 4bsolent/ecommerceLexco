<?php

namespace App\Traits;

trait JsonResponse {

    /**
        *Respuesta Estandar para Exito de la API
        *
        *Devuelve una respuesta JSON con un mensaje de exito y un codigo de estado
        *
        * @param string  $message El mensaje es opcional en caso de querer personalizar la respuesta
        * @param mixed  $data Los datos que se quieren devolver
        * @param int $code El codigo de estado HTTP
        * @return \Illuminate\Http\JsonResponse
    */

    public static function successResponse($data, $code, $message = null) {
        $message = $message ?? (($code == 201) ? 'Creado exitosamente' : 'Respuesta exitosa');

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
        *Respuesta Estandar para Exito de la API
        *
        *Devuelve una respuesta JSON con un mensaje de exito y un codigo de estado
        *
        * @param string  $message El mensaje es opcional en caso de querer personalizar la respuesta
        * @param mixed  $data Los datos que se quieren devolver
        * @param int $code El codigo de estado HTTP
        * @return \Illuminate\Http\JsonResponse
    */

    public static function errorResponse( $data, $code, $message = null) {

        $message = $message ?? (($code == 401) ? 'Error en la autenticación' : 'Error en la validación de datos');

        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $data
        ], $code);
    }
}

