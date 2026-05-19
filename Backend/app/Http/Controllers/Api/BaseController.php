<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


class BaseController extends Controller
{
    /**
     * Base Controller Response Helper
     */

     protected function success($data = null, string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data, 
        ], $code);
    }

    protected function created($data = null, string $message = 'Created successfully')
    {
        return $this->success($data, $message, 201);
    }
    

    protected function deleted(string $message = 'Deleted successfully')
    {
        return $this->success(null, $message, 204);
    }

    protected function error(string $message = 'Error', int $code = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    protected function unauthorized(string $message = 'Unauthorized')
    {
        return $this->error($message, 401);
    }

    protected function forbidden(string $message = 'Forbidden')
    {
        return $this->error($message, 403);
    }

    protected function notFound(string $message = 'Not Found')
    {
        return $this->error($message, 404);
    }
}
