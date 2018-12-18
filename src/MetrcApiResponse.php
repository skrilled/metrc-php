<?php

namespace MetrcApi;

use MetrcApi\Exception\InvalidMetrcResponseException;

class MetrcApiResponse
{
    public $success = false;
    public $httpCode;
    public $rawResponse;
    public $response;

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param mixed $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return mixed
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param mixed $httpCode
     */
    public function setHttpCode($httpCode)
    {
        if($httpCode == 200) {
            $this->setSuccess(true);
        } else {
            $this->setSuccess(false);
        }
        $this->httpCode = $httpCode;
    }

    /**
     * @return mixed
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * @param mixed $rawResponse
     * @throws InvalidMetrcResponseException
     */
    public function setRawResponse($rawResponse)
    {
        try {
            $this->setResponse(json_decode($rawResponse, true));
        }
        catch(\Exception $e) {
            throw new InvalidMetrcResponseException($rawResponse);
        }
        $this->rawResponse = $rawResponse;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }
}