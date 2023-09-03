<?php
  // Headers for API
  header('Access-Control-Allow-Methods: PUT'); // PUT for Update operation.
  include_once 'header.php';


  //Check if Contact exist within List before delete operation
  $result = $contact->check();
  $num = $result->rowCount();    // Get total row count.

  if($num > 0) {

    // Soft Delete Contact
    $contact->delete();
    echo json_encode(
      array('message' => 'Contact Deleted')
    );

  }else{

    echo json_encode(
      array('message' => 'No record Found! or Check the Recycle Bin')
    );

  }

?>

 