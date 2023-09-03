<?php
  // Headers for API
  header('Access-Control-Allow-Methods: PUT'); // PUT for Update operation.
  include_once 'header.php';



  // Check if record exist before restore operation.

  $result = $contact->checkrestore();
  $num = $result->rowCount();    // Get total row count.

  // Return Contact List into row
  if($num > 0) {
   
      // Soft Delete Contact
      if($contact->restore()) {
        echo json_encode(
          array('message' => 'Contact Resorted Successfully')
        );
      } 
    
    } else {
      // No Posts
      echo json_encode(
        array('message' => 'No Contacts Found')
      );
    }
    
?>

