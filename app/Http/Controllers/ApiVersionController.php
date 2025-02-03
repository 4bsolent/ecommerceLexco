<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use config\app;

class ApiVersionController extends Controller
{
    public function index () {

        $apiVersion = config('app.apiversion');

        return response()->json([
            'message' => 'API Prueba Técnica Laravel Lexco SA',
            'APIversion' => $apiVersion,
        ]);
    }
}
