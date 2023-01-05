<?php

require_once "config.php";

/**
 * This class is used to represent the data in the database
 * and to perform database operations.
 */
abstract class BaseModel
{
  private static $connection = null;

  /**
   * This function is used to retrieve the database connection object.
   *
   * If the connection has not been established yet, it will be created
   * the first time that this function is called.
   */
  private static function getOrSetConnection()
  {
    $config = Config::getConfig();

    // If the connection is not set, set it.
    if (!isset(self::$connection))
      self::$connection = new PDO("mysql:host=$config->databaseHost;dbname=$config->databaseName", $config->databaseUsername, $config->databasePassword);

    return self::$connection;
  }

  /**
   * The unique identifier for this specific record on the database.
   */
  public $id;

  /**
   * Get a specific record from the database.
   */
  static function getRecord($id)
  {
    $connection = BaseModel::getOrSetConnection();
    $query = $connection->prepare("SELECT * FROM notes WHERE id=:id");

    // NOTE: We use 'bindValue' instead of string interpolation (putting a
    // variable inside a string) to fill up the 'id' in the query, and
    // also to avoid possible SQL injection attacks.
    $result = $query->execute(['id' => $id]);
    return $result;
  }

  /**
   * Get all the records from the database.
   */
  static function allRecords()
  {
    $connection = BaseModel::getOrSetConnection();
    $query = $connection->prepare("SELECT * FROM notes");
    $query->execute();
    return $query->fetchAll();
  }

  static function addRecord($title, $content)
  {
    $connection = BaseModel::getOrSetConnection();
    $query = $connection->prepare("INSERT INTO notes (title, content) VALUES (:title, :content)");
    $result = $query->execute(['title' => $title, 'content' => $content]);
    return $result;
  }

  static function modRecord($id, $content)
  {
    $connection = BaseModel::getOrSetConnection();
    // $query = $connection->prepare("UPDATE notes (title, content) VALUES (:title, :content)");
    $query = $connection->prepare("UPDATE notes SET title=:content WHERE id=:id");
    $result = $query->execute(['id' => $id, 'content' => $content]);
    return $result;
  }

  static function delRecord($id, $entryNum)
  {
    var_dump($id, $entryNum);

    if ($entryNum == $id) {
      $connection = BaseModel::getOrSetConnection();
      $query = $connection->prepare("DELETE FROM notes WHERE id=:id");
      $result = $query->execute(['id' => $id]);
      return $result;
    }
  }
}
