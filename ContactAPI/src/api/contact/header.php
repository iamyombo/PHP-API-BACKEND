<?php 
  // Headers
  header('Access-Control-Allow-Origin: *'); // For Public Access to Endpoints
  header('Content-Type: application/json'); // To return JSON format Contents.
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  // Includes file for Database connect and Contact Model.
  include_once '../../config/Database.php';
  include_once '../../models/Contact.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Contact object
  $contact = new Contact($db);

?>

