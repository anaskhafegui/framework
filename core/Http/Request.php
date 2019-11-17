<?php

namespace Core\Http;

use Core\Interfaces\RequestInterface;

class Request implements RequestInterface {

    /**
     * Singleton Instance
     *
     * @var mixed
     */
    private static $instance;

    /**
     * Get Request Instance
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if(is_null(static::$instance)){
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $input){
        return isset($_GET[$input]) ? $_GET[$input] : null;
    }
    
    /**
     * {@inheritDoc}
     */
    public function post(string $input){
        return isset($_POST[$input]) ? $_POST[$input] : null;
    }
    
    /**
     * {@inheritDoc}
     */
    public function server(string $key ):? string  {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : null;
    }
    
    /**
     * {@inheritDoc}
     */
    public function header(string $header):? string {
        $headers = getallheaders();
        return isset($headers[$header]) ? $headers[$header] : null;
    }
    
    /**
     * {@inheritDoc}
     */
    public function headers(): array{
        return getallheaders();
    }

    /**
     * {@inheritDoc}
     */
    public function isFile(string $input): bool{
        return isset($_FILES[$input]) ? $_FILES[$input] : null;
    }
        
    /**
     * {@inheritDoc}
     */
    public function route(): string {
        return '';
    }
    
    /**
     * {@inheritDoc}
     */
    public function validate(array $rules) {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function isSecure(): bool {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    }
    
    /**
     * {@inheritDoc}
     */
    public function ip(): string {
        
        // needs refactoring!
        
        if(!empty($this->server('HTTP_CLIENT_IP'))){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($this->server('HTTP_X_FORWARDED_FOR'))){
            //ip pass from proxy
            $ip = $this->server('HTTP_X_FORWARDED_FOR');
        }else{
            $ip = $this->server('REMOTE_ADDR');
        }
        return $ip;
    }
    
    /**
     * {@inheritDoc}
     */
    public function userAgent(): string {
        return $this->server('HTTP_USER_AGENT');
    }

    /**
     * {@inheritDoc}
     */
    public function uri(): string {
        $uri = $_SERVER['REQUEST_URI'];
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);

        // remove script name from uri
        $uri = str_replace($scriptName, '', $uri);

        // remove query string from uri
        $uri = explode('?', $uri)[0];
        return $uri;
    }

    /**
     * {@inheritDoc}
     */
    public function url(): string {
        $host = $this->server('HTTP_HOST');
        $uri = $this->server('REQUEST_URI');
        $protocol = (isset($_SERVER['HTTPS']) ? "https" : "http");
        
        return "$protocol://$host$uri";
    }

    /**
     * {@inheritDoc}
     */
    public function __get(string $key){
        // get from $_GET, $_POST, $_REQUEST, $_File
        if($this->get($key)){
            return $this->get($key);
        }

        if($this->post($key)){
            return $this->post($key);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists ($offset ) : bool{
        return isset($this->$offset) ? true : false;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet ( $offset ) :? string {
        return $this->$offset;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet ( $offset , $value ) : void {
        $this->$offset = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset ( $offset ) : void {
        $this->$offset = null;
    }
}