<?php

namespace Core\Interfaces;

interface ResponseInterface
{
    /**
     * Set the response content
     * 
     * @param   string $content
     * @return  ResponseInterface
     */
    public function setContent($content);    

    /**
     * Set the response headers
     * 
     * @param   array $headers
     * @return  ResponseInterface
     */
    public function setHeaders(array $headers);    

    /**
     * Send response
     * If the given content is an array or is Arrayable, then send response as json response
     * 
     * @param  string|array $content
     * @param  int          $statusCode
     * @param  array        $headers
     * @return string
     */
    public function send();

    
    /**
     * Display the content on the screen
     */
    public function sendContent();

    /**
     * Send headers to the response
     */
    public function sendHeaders();
}