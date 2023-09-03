<?php 

  // Headers for API
  header('Access-Control-Allow-Methods: GET'); // GET for Update operation.
  include_once 'header.php';
  
  // Check if contact exist before pulling contact list.
  $result = $contact->check();
  $num = $result->rowCount();    // Get contact row count.

  // Return Contact Lists to an array if any
  if($num > 0) {
   
    $contact_array = array();    // Contact list Array
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      //print_r($row);

      $contact_item = array(
        //'id' => $id,
        'ContactID' => $ContactID,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'company_id' => $company_id,
        'name' => $name,
        'postcode' => $postcode
        
      );

      // Push the return array to data collection "data"
      array_push($contact_array, $contact_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($contact_array);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Contacts Found')
    );
  }
?>