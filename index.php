<?php
require_once "./api/notes.php";

// Controlling routing and requests.
$requestUri = $_SERVER["REQUEST_URI"]; // Returns the URI from the browser.
$pathParts = explode("/", $requestUri); // Splits the URI into an array.
$baseDir = $pathParts[0]; // Represents the base URL portion.
$controllerName = $pathParts[2]; // Represents the controller name portion.

// Invoke the routing function.
routeRequest($controllerName);

function routeRequest($controllerName)
{
  $controller = null;

  if ($controllerName == "notes")
    $controller = new NoteController();
  else {
    BaseController::sendJSONError("Invalid controller name; your request URL should look something like: 'http://localhost/index.php/notes/'"); // Failure file name
    return;
  }
  $requestMethod = $_SERVER["REQUEST_METHOD"];

  // Depending on the request method that the client sent, invoke the appropriate
  // controller method. If it is an invalid method, return an error message.

  if ($requestMethod == "GET") {
    $controller->get();
  } else if ($requestMethod == "POST") {
    // Get the request body from the client, and decode it into a JSON object.
    $inputJSONString = file_get_contents('php://input');
    $requestData = json_decode($inputJSONString);
    // Then, pass it into the post method.
    $controller->post($requestData);
  } else if ($requestMethod == "PUT") {
    $inputJSONString = file_get_contents('php://input');
    $modData = json_decode($inputJSONString);
    $controller->update($modData);
  } else if ($requestMethod == "DEL") {
    $inputJSONString = file_get_contents('php://input');
    $delData = json_decode($inputJSONString);
    $controller->delRecord($delData);
  } else {
    BaseController::sendJSONError("Invalid request method");
    return;
  }

  // Browser/client -> prepare request "data: {title: ..., content: ...} -> send request
  // Server -> receive the request -> find appropriate handler/controller (notes) -> invoke the appropriate method (post)
  // NoteController::post($requestData) -> insert that data into the database
}
