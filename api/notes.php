<?php
require_once "api/baseController.php";
require_once "models/note.php";

/**
 * This note controller is responsible for handling requests
 * related to notes.
 *
 * It is based off the CRUD model.
 */
class NoteController extends BaseController
{
  public function get()
  {
    // Get all the notes from the database. Find this function in model/note folder
    $notes = Note::allRecords();

    if (!$notes) {
      $errMessage = 'A database operation failed. Database empty, no records!';
      BaseController::sendJSONError($errMessage);
    } else {
      BaseController::sendJson($notes);
    }
  }

  public function post($requestData)
  {
    $notes = Note::addRecord($requestData->title, $requestData->content);

    if (!$notes) {
      $errMessage = 'A database operation failed. Error occurred!';
      BaseController::sendJSONError($errMessage);
    } else {
      BaseController::sendJson(array('success' => true));
    }
  }

  public function update($modData)
  {
    $notes =  Note::modRecord($modData->id, $modData->content);

    if (!$notes) {
      $errMessage = 'A database operation failed. Error occurred!';
      BaseController::sendJSONError($errMessage);
    } else {
      BaseController::sendJson(array('success' => true));
    }
  }

  public function delRecord($delData)
  {
    $notes =  Note::delRecord($delData->id, $delData->content);
    if (!$notes) {
      $errMessage = 'A database operation failed. Invalid note ID!';
      BaseController::sendJSONError($errMessage);
    } else {
      BaseController::sendJson(array('success' => true));
    }
  }
}
