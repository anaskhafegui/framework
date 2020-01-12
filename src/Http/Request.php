<?php

namespace Core\Http;

use Core\Interfaces\RequestInterface;
use Core\Validator\Validator;

class Request implements RequestInterface
{
    /**
     * Singleton Instance.
     *
     * @var mixed
     */
    private static $instance;

    /**
     * validator object.
     *
     * @var mixed
     */
    private $validator;

    private function __construct()
    {
        $this->validator = new Validator();
    }

    /**
     * Get Request Instance.
     *
     * @return mixed
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public static function create($uri = '/', $method = 'GET')
    {
        $components = parse_url($uri);

        if (isset($components['path'])) {
            $path = $components['path'];
        }

        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['SERVER_PORT'] = 80;
        $_SERVER['REQUEST_URI'] = $path;
        $_SERVER['REQUEST_METHOD'] = strtoupper($method);
        $_SERVER['SCRIPT_NAME'] = '';
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $input)
    {
        return $_GET[$input] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $input)
    {
        return $_POST[$input] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function server(string $key): ?string
    {
        return $_SERVER[$key] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function header(string $header): ?string
    {
        $headers = $this->headers();

        return $headers[$header] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function headers(): array
    {
        return getallheaders();
    }

    /**
     * {@inheritdoc}
     */
    public function isFile(string $input): bool
    {
        return $_FILES[$input] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(array $rules)
    {
        $errors = $this->validator->validate($rules);

        return $errors ?? true;
    }

    /**
     * {@inheritdoc}
     */
    public function isSecure(): bool
    {
        return !empty($this->server('HTTPS')) && $this->server('HTTPS') !== 'off';
    }

    /**
     * {@inheritdoc}
     */
    public function ip(): string
    {

        // needs refactoring!

        if (!empty($this->server('HTTP_CLIENT_IP'))) {
            //ip from share internet
            $ip = $this->server('HTTP_CLIENT_IP');
        } elseif (!empty($this->server('HTTP_X_FORWARDED_FOR'))) {
            //ip pass from proxy
            $ip = $this->server('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $this->server('REMOTE_ADDR');
        }

        return $ip;
    }

    /**
     * {@inheritdoc}
     */
    public function userAgent(): string
    {
        return $this->server('HTTP_USER_AGENT');
    }

    /**
     * {@inheritdoc}
     */
    public function uri(): string
    {
        $uri = $this->server('REQUEST_URI');
        $scriptName = dirname($this->server('SCRIPT_NAME'));

        // remove script name from uri
        $uri = str_replace($scriptName, '', $uri);

        // remove query string from uri
        $uri = explode('?', $uri)[0];

        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function url(): string
    {
        $host = $this->server('HTTP_HOST');
        $uri = $this->server('REQUEST_URI');
        $protocol = $this->isSecure() ? 'https' : 'http';

        return "$protocol://$host$uri";
    }

    /**
     * {@inheritdoc}
     */
    public function __get(string $key)
    {
        // get from $_GET, $_POST, $_REQUEST, $_File
        if ($this->get($key)) {
            return $this->get($key);
        }

        if ($this->post($key)) {
            return $this->post($key);
        }

        // use file() method
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool
    {
        return isset($this->$offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset): ?string
    {
        return $this->$offset;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
        $this->$offset = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset): void
    {
        $this->$offset = null;
    }

    /**
     * {@inheritdoc}
     */
    public function all(): iterable
    {
        return $_REQUEST;
    }
}
