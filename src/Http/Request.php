<?php

namespace Amrudinbalic\Marketplace\Http;

class Request
{
    /**
     * Get the request method (GET, POST, etc.)
     *
     * @return string
     */
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * Get the request URI
     *
     * @return string
     */
    public static function path(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Remove base path if present
        $basePath = '/marketplace/';
        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }
        
        // Ensure URI starts with /
        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }
        
        return $uri;
    }

    /**
     * Get all request parameters
     *
     * @return array
     */
    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    /**
     * Get specific query parameters by key(s).
     *
     * @param string|array|null $key
     * @return array|mixed|null
     */
    public function query(string|array $key = null): mixed
    {
        // multiple keys
        if (is_array($key)) {
            $result = [];
            foreach ($key as $k) {
                $result[$k] = $_GET[$k] ?? null;
            }
            return $result;
        }

        // single key
        if (is_string($key)) {
            return $_GET[$key] ?? null;
        }

        // return all query parameters
        return $_GET;
    }

    /**
     * Get a specific request body parameter by key.
     *
     * @param string|array|null $key
     * @return array|mixed|null
     */
    public function body(string|array $key = null): mixed
    {
        // multiple keys
        if (is_array($key)) {
            $result = [];
            foreach ($key as $k) {
                $result[$k] = $_POST[$k] ?? null;
            }
            return $result;
        }

        // single key
        if (is_string($key)) {
            return $_POST[$key] ?? null;
        }

        // return all body parameters
        return $_POST;
    }

    /**
     * Validate that an incoming value is existing and not an empty one.
     *
     * @param array $required The keys to validate do they exist.
     * @return array|false
     */
    public function validate(array $required): array|false {
        $all = $this->all();
        $validated = [];

        foreach($required as $item) {

            if(empty($all[$item])) {
                return false;
            }

            $validated[] = $all[$item];

        }

        return $validated;
    }
}