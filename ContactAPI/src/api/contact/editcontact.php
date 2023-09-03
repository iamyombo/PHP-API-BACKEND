<?php 

  // Headers for API
  header('Access-Control-Allow-Methods: POST'); // POST for Update operation.
  include_once 'header.php';

  //Check if Contact exist within List before edit operation
  $result = $contact->check();
  $num = $result->rowCount();    // Get total row count.

  // Return Contact Lists to an array if any
  if($num > 0) {
  
      $contact->firstname = $_POST['firstname'];
      $contact->lastname = $_POST['lastname'];
      $contact->email = $_POST['email'];
      $contact->company_id = $_POST['company_id'];

      // Update contact in List
      if($contact->editcontact()) {
        echo json_encode(
          array('message' => 'Contact Updated Successfully')
        );
      } 

    } else {
      // No Posts
      echo json_encode(
        array('message' => 'No Contacts Found')
      );
    }
    
?>

