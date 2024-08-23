<?php

namespace App\Classes;

class Response
{

    public $json;


    public function response($data, $message = '', $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        $this->json = json_encode([
            'data' => $data,
            'status' => $status,
            'message' => $message
        ]);
    }

    public function fail($message = '', $status = 400)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        $this->json = json_encode([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function success($data, $message = '', $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        $this->json = json_encode([
            'data' => $data,
            'status' => $status,
            'message' => $message
        ]);
        return $this;
    }

    public function error($message = '', $status = 500)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        $this->json = json_encode([
            'status' => $status,
            'message' => $message
        ]);
        return $this;
    }

    public function send()
    {
        echo $this->json;
        die();
    }

    public function notFound($message = 'Not Found', $status = 404)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        $this->json = json_encode([
            'status' => $status,
            'message' => $message
        ]);
        return $this;

    }

    public function unauthorized($message = 'Unauthorized', $status = 401)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        $this->json = json_encode([
            'status' => $status,
            'message' => $message
        ]);
    }


    public function forbidden($message = 'Forbidden', $status = 403)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        $this->json = json_encode([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function methodNotAllowed($message = 'Method Not Allowed', $status = 405)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        $this->json = json_encode([
            'status' => $status,
            'message' => $message
        ]);
    }
}