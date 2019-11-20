<?php 

namespace Core\Interfaces;

interface SessionInterface
{
    public function has($key): bool;

    public function get($key);

    public function set($key, $value);

    public function forget($key);

    public function all(): iterable;

    public function start();

    public function destroy();

    public function flash($key, $value);
}