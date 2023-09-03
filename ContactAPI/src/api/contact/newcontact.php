<?php 

  // Headers for API
  header('Access-Control-Allow-Methods: POST'); // POST for Update operation.
  include_once 'header.php';

  $contact->firstname = $_POST['firstname'];
  $contact->lastname = $_POST['lastname'];
  $contact->email = $_POST['email'];
  $contact->company_id = $_POST['company_id'];

  // Create contact
  if($contact->newcontact()) {
    echo json_encode(
      array('message' => 'Contact Created Successfully')
    );
  } else {
    echo json_encode(
      array('message' => 'Contact Not Created')
    );
  }

?>