<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Response as HttpResponse;

class ApiController extends Controller
{
    use ApiResponse;

    public function generalSuccessResponse(array $data = [], $message = null, $key = null)
    {
        if ($message == null) $message = "action complete";
        if ($key == null) $key = "data";

        return $this->setSuccessFlag(true)->setHttpStatus(HttpResponse::HTTP_OK)->setData($data)->setMessage($message)->setDataKey($key)->respond();
    }

    public function objectCreatedResponse(array $data = [], $message = "action complete")
    {
        return $this->setSuccessFlag(true)->setHttpStatus(HttpResponse::HTTP_CREATED)->setData($data)->setMessage($message)->respond();
    }

    public function unprocessedEntityResponse($message = "could not complete request", $error = "")
    {
        return $this->setSuccessFlag(false)->setHttpStatus(HttpResponse::HTTP_UNPROCESSABLE_ENTITY)->setError($error)->setMessage($message)->respond();
    }

    public function unauthorizedResponse($message = "wrong credentials")
    {
        return $this->setSuccessFlag(false)->setHttpStatus(HttpResponse::HTTP_UNAUTHORIZED)->setMessage($message)->respond();
    }

    public function expectationFailedResponse($message = "could not complete action", $error = "")
    {
        return $this->setSuccessFlag(false)->setHttpStatus(HttpResponse::HTTP_EXPECTATION_FAILED)->setError($error)->setMessage($message)->respond();
    }

    public function conflictResponse($message = "account already exists", $error = "")
    {
        return $this->setSuccessFlag(false)->setHttpStatus(HttpResponse::HTTP_CONFLICT)->setError($error)->setMessage($message)->respond();
    }

    public function generalErrorResponse($httpCode, $error)
    {
        return $this->setSuccessFlag(false)->setHttpStatus($httpCode)->setError($error)->respond();
    }

    public function objectNotFoundResponse($message = 'Object Not Found')
    {
        return $this->setSuccessFlag(false)->setHttpStatus(HttpResponse::HTTP_NOT_FOUND)->setMessage($message)->respond();
    }

    public function internalServerErrorResponse($message = 'Internal Server Error')
    {
        return $this->setSuccessFlag(false)->setHttpStatus(HttpResponse::HTTP_INTERNAL_SERVER_ERROR)->setMessage($message)->respond();
    }

    public function forbiddenResourceResponse($message = 'Forbidden!')
    {
        return $this->setSuccessFlag(false)->setHttpStatus(HttpResponse::HTTP_FORBIDDEN)->setMessage($message)->respond();
    }
}
