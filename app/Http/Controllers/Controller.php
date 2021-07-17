<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return generic json response with the given data.
     *
     * @param $data
     * @param bool $success
     * @param array $messages
     *
     * @return JsonResponse
     */
    protected function apiResponse($data = [], $success = true, $messages = [])
    {
        return response()->json(
            [
                'success' => $success,
                'message' => $messages ?? null,
                'result' => $data ?? null,
            ]
        );
    }
}
