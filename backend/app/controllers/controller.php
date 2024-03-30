<?php

namespace Controllers;

use Exception;

class Controller
{
    function respond($data)
    {
        $this->respondWithCode(200, $data);
    }

    function respondWithError($httpcode, $message)
    {
        $data = array('errorMessage' => $message);
        $this->respondWithCode($httpcode, $data);
    }

    function respondWithCode($httpcode, $data)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpcode);
        echo json_encode($data);
    }

    function createObjectFromPostedJson($className)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        if (empty($data)) {
            throw new Exception("Invalid JSON data.");
        }

        $object = new $className();
        foreach ($data as $key => $value) {
            if(is_object($value)) {
                continue;
            }
            $object->{$key} = $value;
        }
        return $object;
    }

    function getPostedJson()
    {
        $json = file_get_contents('php://input');
        return json_decode($json);
    }

    function getBearerToken()
    {
        $headers = apache_request_headers();
        return $headers['Authorization'] ?? null;
    }
}
