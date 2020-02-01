<?php

namespace Core\Controllers;

abstract class ApiController extends BaseController
{
    private $statusCode = 200;

    private $message;

    public function success($resource)
    {
        return [
            'status_code'   => $this->getStatusCode(),
            'data'          => $resource,
        ];
    }

    public function error($code, $message)
    {
        $this->setStatusCode($code)->setMessage($message);
    }

    public function notFound($message = 'Resource Not Found')
    {
        $this->error(404, $message);
    }

    public function forbidden($message = 'Forbidden')
    {
        $this->error(403, $message);
    }

    public function internalError($message = 'Internal Error')
    {
        $this->error(500, $message);
    }

    public function unauthorized($message = 'Unauthorized')
    {
        $this->error(401, $message);
    }

    public function wrongArgs($message = 'Wrong Arguments')
    {
        $this->error(400, $message);
    }

    private function setStatusCode($code): self
    {
        $this->statusCode = $code;

        return $this;
    }

    private function setMessage($message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
