<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successJsonResponse(array $data = []) 
    {
        return json_encode([
            'status' => 1,
            'data'   => $data
        ]);
    }

    public function errorJsonResponse(string $errorMessage = '') 
    {
        return json_encode([
            'status' => 0,
            'error'   => $errorMessage
        ]);
    }
}
