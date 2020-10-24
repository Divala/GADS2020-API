<?php

namespace App\Traits;


use Illuminate\Http\Response;

trait ApiResponse
{
    private $responseSuccess = false;
    private $responseStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
    private $responseError = null;
    private $responseMessage = null;
    private $responseData = null;
    private $responseHeaders = [];
    private $responseDataKey = "data";


    protected function setData($data)
    {
        $this->responseData = $data;
        return $this;
    }

    protected function setError($error)
    {
        $this->responseError = $error;
        return $this;
    }

    protected function setSuccessFlag($success)
    {
        $this->responseSuccess = $success;
        return $this;
    }

    protected function setMessage($message)
    {
        $this->responseMessage = $message;
        return $this;
    }

    protected function setHeaders(array $headers)
    {
        $this->responseHeaders = $headers;
        return $this;
    }

    protected function setDataKey($key)
    {
        $this->responseDataKey = $key;

        return $this;
    }

    protected function setHttpStatus($code)
    {
        $this->responseStatusCode = $code;
        return $this;
    }

    protected function respond()
    {
        $data = [
            "result" => [
                "success" => $this->getSuccessFlag(),
                "code" => $this->getHttpStatus(),
                "error" => $this->getError(),
                "message" => $this->getResponseMessage()
            ],
            $this->responseDataKey => $this->getData()
        ];

        return response()->json($data, $this->responseStatusCode, $this->responseHeaders, JSON_PRETTY_PRINT);
    }

    private function getSuccessFlag()
    {
        return (bool)$this->responseSuccess;
    }

    private function getHttpStatus()
    {
        return $this->responseStatusCode;
    }

    private function getError()
    {
        return $this->responseError;
    }

    private function getResponseMessage()
    {
        return $this->responseMessage;
    }

    private function getData()
    {
        if ($this->responseData === []) {
            return null;
        }

        return $this->responseData;
    }
}