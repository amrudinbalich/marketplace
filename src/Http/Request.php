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

    public function get(string|array $key): mixed
    {
        $source = $_GET ?? $_POST;

        if(!$source) {
            $source = json_decode(file_get_contents('php://input'), true);
        }

        // list of keys
        if (is_array($key)) {
            $result = [];
            foreach ($key as $k) {
                $result[$k] = $source[$k] ?? null;
            }
            return $result;
        }

        // single key
        return $source[$key] ?? null;
    }

    public function isset(string $key): bool
    {
        return isset($_GET[$key]) || isset($_POST[$key]);
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