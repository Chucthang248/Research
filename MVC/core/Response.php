<?php
namespace Core;

class Response {
    /**
     * Send a JSON response with specified HTTP status code
     *
     * @param mixed $data The data to be encoded as JSON
     * @param int $status HTTP status code
     * @return void
     */
    public static function json($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    /**
     * Send an error response
     *
     * @param string|array $message Error message or messages
     * @param int $status HTTP status code
     * @return void
     */
    public static function error($message, $status = 400) {
        return self::json(['error' => $message], $status);
    }

    /**
     * Send a success response
     *
     * @param mixed $data Response data
     * @param string $message Success message
     * @param int $status HTTP status code
     * @return void
     */
    public static function success($data, $message = 'Success', $status = 200) {
        return self::json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
