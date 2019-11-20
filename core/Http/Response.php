<?php

namespace Core\Http;

use Interfaces\ResponseInterface;

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
    public function setContent($content): ResponseInterface 
    {
        if (is_array($content)) {
            $this->content = json_encode($content);
        } else {
            $this->content = $content;
        }

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

            foreach ($this->headers as $key => $values) {
                foreach($values as $value) {
                    header($key.': '.$value);   
                }
            }
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
    private function setHeader($key, $values)
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
     * {@inheritDoc}
     */
    public function send($content, int $statusCode, array $headers): ResponseInterface 
    {
        if (is_array($content)) {
            return $this->sendJson($content, $statusCode, $headers);
        }

        $this->setHeaders($headers);
        $this->setContent($content);
        $this->setStatusCode($statusCode);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function sendJson(iterable $content, int $statusCode, array $headers): ResponseInterface 
    {

        $this->setHeaders($headers);
        $this->setContent($content);
        $this->setStatusCode($statusCode);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function sendFIle(string $filePath, int $statusCode, array $headers): ResponseInterface 
    {
        $this->setHeaders($headers);
        $this->setStatusCode($statusCode);

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
        return sprintf('HTTP/%s %s', '1.1', $this->statusCode)."\n". $this->content. "\n header : ". implode("\n header : ",headers_list());
    }
}