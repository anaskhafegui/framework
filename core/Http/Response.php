<?php

namespace Core\Http;

use Core\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    /**
     * Response Headers
     * @var mixed
     */
    public $headers;

    /**
     * Response Content
     * @var Response Content
     */
    protected $content;

    /**
     * Response Status Code
     * @var int
     */
    protected $statusCode;

    /**
     * Singleton Instance
     *
     * @var mixed
     */
    private static $instance;

    private function __construct() 
    {
        
    }

    /**
     * Get Router Instance
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * {@inheritDoc}
     */
    public function setContent(string $content): ResponseInterface 
    {
        $this->content = $content;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setStatusCode(int $statusCode): ResponseInterface 
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers): ResponseInterface 
    {
        foreach ($headers as $key => $values) {
            $this->setHeader($key, $values);
        }
        
        return $this;
    }

    /**
     * Set single header
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setHeader($key, $values)
    {
        if (is_array($values)) {
            $values = array_values($values);

            if (! isset($this->headers[$key])){
                $this->headers[$key] = $values;
            } else {
                $this->headers[$key] = array_merge($this->headers[$key], $values);
            }
        } else {
            if (! isset($this->headers[$key])){
                $this->headers[$key] = [$values];
            } else {
                $this->headers[$key][] = $values;
            }
        }
    }

    /**
     * Send Response Headers
     *
     * @param string $headers
     * @return void
     */
    public function sendHeaders($headers)
    {
        foreach ($headers as $key => $values) {
            header($key.': '.$values);
        }
    }

    /**
     * * Send Response Content
     *
     * @param string $content
     * @return void
     */
    public function sendContent($content)
    {
        if (is_array($content)) {
            $this->content = json_encode($content);
        } else {
            $this->content = $content;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function send($content, int $statusCode, array $headers): ResponseInterface 
    {
        if (is_array($content)) {
            return $this->sendJson($content, $statusCode, $headers);
        }

        header('Status: '.$statusCode);

        $this->sendHeaders($headers);
        $this->sendContent($content);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function sendJson(iterable $content, int $statusCode, array $headers): ResponseInterface 
    {
        $this->sendContent($content);

        header('Status: '.$statusCode);

        $this->sendHeaders($headers);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function sendFIle(string $filePath, int $statusCode, array $headers): ResponseInterface 
    {
        header('Status: '.$statusCode);

        foreach ($headers as $key => $values) {
            header($key.': '.$values);
        }

        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Length:".filesize($filePath));
        header("Content-Disposition: attachment; filename=fileName.zip");
        readfile($filePath);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string 
    {
        return
            sprintf('HTTP/%s %s', '1.1', $this->statusCode)."\r\n".
            $this->headers."\r\n".
            $this->content;

    }
}