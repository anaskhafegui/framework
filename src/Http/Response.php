<?php

namespace Core\Http;

use Core\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    /**
     * Response Headers
     * @var mixed
     */
    public $headers = [];

    /**
     * Response Content
     * @var Response Content
     */
    protected $content;

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
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * {@inheritDoc}
     */
    public function setContent($content) 
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
    public function setHeaders(array $headers) 
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
    public function send() 
    {
        $this->sendHeaders();
        $this->sendContent();
    }

    
    /**
     * {@inheritDoc}
     */
    public function sendContent()
    {
        echo $this->content;
    }

    /**
     * {@inheritDoc}
     */
    public function sendHeaders()
    {
        foreach ($this->headers as $key => $values) {
            foreach($values as $value) {
                header($key.': '.$value);   
            }
        }
    }
}