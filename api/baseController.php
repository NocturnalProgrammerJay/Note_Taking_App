<?php

/**
 * This serves as the superclass for all API controllers.
 *
 * It also has some helper functions to be used when dealing with
 * requests.
 * 
 * This serves as the communication tools with the frontend/client.
 */

class BaseController
{
  static function sendJSONError($errMessage)
  {
    //Gets sent to client as data 'Response {type: 'basic', url: 'http://localhost/api/notes', redirected: false, status: 500, ok: false, …'
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo json_encode(['success' => false, 'message' => $errMessage]);
  }

  static function sendJson($data)
  {
    header("Content-Type: application/json", "HTTP/1.1 200 OK");
    echo json_encode($data);
    //SUCCESS: TRUE <--- if array = true else array = false so SUCESS: false

  }
}
